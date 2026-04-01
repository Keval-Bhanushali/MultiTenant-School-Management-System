import './bootstrap';

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

function initLoader() {
	const loader = document.querySelector('[data-global-loader]');
	if (!loader) {
		return;
	}

	const showLoader = () => {
		loader.classList.remove('pointer-events-none', 'opacity-0');
		loader.classList.add('opacity-100');
	};

	const hideLoader = () => {
		loader.classList.add('pointer-events-none', 'opacity-0');
		loader.classList.remove('opacity-100');
	};

	window.addEventListener('beforeunload', showLoader);
	window.addEventListener('load', hideLoader);

	document.querySelectorAll('[data-load-transition], form').forEach((element) => {
		element.addEventListener('submit', () => {
			showLoader();
		});
	});

	document.querySelectorAll('a[data-load-transition="true"]').forEach((link) => {
		link.addEventListener('click', () => {
			showLoader();
		});
	});
}

function initParticleField() {
	const canvas = document.querySelector('[data-particle-field]');
	if (!canvas || reduceMotion) {
		return;
	}

	const context = canvas.getContext('2d');
	if (!context) {
		return;
	}

	const pointer = { x: window.innerWidth / 2, y: window.innerHeight / 2 };
	const nodes = Array.from({ length: 62 }, () => ({
		x: Math.random() * window.innerWidth,
		y: Math.random() * window.innerHeight,
		vx: (Math.random() - 0.5) * 0.28,
		vy: (Math.random() - 0.5) * 0.28,
	}));

	const resize = () => {
		canvas.width = window.innerWidth * window.devicePixelRatio;
		canvas.height = window.innerHeight * window.devicePixelRatio;
		canvas.style.width = `${window.innerWidth}px`;
		canvas.style.height = `${window.innerHeight}px`;
		context.setTransform(window.devicePixelRatio, 0, 0, window.devicePixelRatio, 0, 0);
	};

	const draw = () => {
		context.clearRect(0, 0, window.innerWidth, window.innerHeight);

		nodes.forEach((node) => {
			node.x += node.vx;
			node.y += node.vy;

			if (node.x < -20) node.x = window.innerWidth + 20;
			if (node.x > window.innerWidth + 20) node.x = -20;
			if (node.y < -20) node.y = window.innerHeight + 20;
			if (node.y > window.innerHeight + 20) node.y = -20;

			const dx = node.x - pointer.x;
			const dy = node.y - pointer.y;
			const distance = Math.sqrt(dx * dx + dy * dy);
			const influence = Math.max(0, 1 - distance / 220);

			node.x += (dx * influence * 0.008);
			node.y += (dy * influence * 0.008);

			context.beginPath();
			context.fillStyle = `rgba(255, 255, 255, ${0.22 + influence * 0.32})`;
			context.arc(node.x, node.y, 1.6 + influence * 1.3, 0, Math.PI * 2);
			context.fill();
		});

		for (let i = 0; i < nodes.length; i += 1) {
			for (let j = i + 1; j < nodes.length; j += 1) {
				const left = nodes[i];
				const right = nodes[j];
				const dx = left.x - right.x;
				const dy = left.y - right.y;
				const distance = Math.sqrt(dx * dx + dy * dy);

				if (distance < 140) {
					context.beginPath();
					context.strokeStyle = `rgba(255, 255, 255, ${(1 - distance / 140) * 0.13})`;
					context.lineWidth = 1;
					context.moveTo(left.x, left.y);
					context.lineTo(right.x, right.y);
					context.stroke();
				}
			}
		}

		requestAnimationFrame(draw);
	};

	window.addEventListener('resize', resize);
	window.addEventListener('pointermove', (event) => {
		pointer.x = event.clientX;
		pointer.y = event.clientY;
	});

	resize();
	draw();
}

function initPricingToggle() {
	const monthlyToggle = document.getElementById('monthlyToggle');
	const yearlyToggle = document.getElementById('yearlyToggle');
	const priceMap = window.__AURACAMPUS_PRICING__;

	if (!monthlyToggle || !yearlyToggle || !priceMap) {
		return;
	}

	const priceNodes = Array.from(document.querySelectorAll('[data-price-monthly]'));
	const unitNodes = Array.from(document.querySelectorAll('[data-price-unit]'));

	const setActive = (mode) => {
		const isMonthly = mode === 'monthly';
		monthlyToggle.dataset.active = String(isMonthly);
		yearlyToggle.dataset.active = String(!isMonthly);

		monthlyToggle.classList.toggle('bg-white/15', isMonthly);
		yearlyToggle.classList.toggle('bg-white/15', !isMonthly);
		monthlyToggle.classList.toggle('text-white', isMonthly);
		yearlyToggle.classList.toggle('text-white', !isMonthly);
		monthlyToggle.classList.toggle('text-slate-300', !isMonthly);
		yearlyToggle.classList.toggle('text-slate-300', isMonthly);

		priceNodes.forEach((node) => {
			const plan = node.getAttribute('data-price-monthly');
			if (plan && priceMap[mode] && priceMap[mode][plan]) {
				node.textContent = priceMap[mode][plan];
			}
		});

		unitNodes.forEach((node) => {
			node.textContent = priceMap[mode].note;
		});
	};

	monthlyToggle.addEventListener('click', () => setActive('monthly'));
	yearlyToggle.addEventListener('click', () => setActive('yearly'));

	setActive('monthly');
}

async function initSuperadminCharts() {
	const chartNodes = Array.from(document.querySelectorAll('[data-superadmin-chart]'));
	if (chartNodes.length === 0) {
		return;
	}

	const { Chart, LineController, LineElement, PointElement, LinearScale, CategoryScale, Filler, Tooltip, Legend } = await import('chart.js');
	Chart.register(LineController, LineElement, PointElement, LinearScale, CategoryScale, Filler, Tooltip, Legend);

	chartNodes.forEach((canvas) => {
		const context = canvas.getContext('2d');
		if (!context) {
			return;
		}

		const labels = JSON.parse(canvas.dataset.labels ?? '[]');
		const values = JSON.parse(canvas.dataset.values ?? '[]');
		const variant = canvas.dataset.superadminChart ?? 'revenue';
		const color = variant === 'tenants' ? 'rgba(168, 85, 247, 0.92)' : 'rgba(34, 211, 238, 0.92)';

		new Chart(context, {
			type: 'line',
			data: {
				labels,
				datasets: [{
					label: variant === 'tenants' ? 'Active Tenants' : 'Platform Revenue',
					data: values,
					borderColor: color,
					backgroundColor: `${color.replace('0.92', '0.18')}`,
					tension: 0.35,
					fill: true,
					pointRadius: 3,
					pointHoverRadius: 4,
				}],
			},
			options: {
				responsive: true,
				maintainAspectRatio: false,
				plugins: {
					legend: { labels: { color: 'rgba(226, 232, 240, 0.88)' } },
				},
				scales: {
					x: { ticks: { color: 'rgba(148, 163, 184, 0.85)' }, grid: { color: 'rgba(148, 163, 184, 0.15)' } },
					y: { ticks: { color: 'rgba(148, 163, 184, 0.85)' }, grid: { color: 'rgba(148, 163, 184, 0.15)' } },
				},
			},
		});
	});
}

document.addEventListener('DOMContentLoaded', () => {
	initLoader();
	initParticleField();
	initPricingToggle();
	initSuperadminCharts();
});
