(function () {
    const CONFIG = {
        size: 200,
        strokeWidth: 25,
        gap: 3,
        defaultColor: '#cbd5e1',
        transition: 'all 0.3s ease'
    };

    const createNode = (tag, attrs = {}) => {
        const el = document.createElementNS('http://www.w3.org/2000/svg', tag);
        Object.entries(attrs).forEach(([k, v]) => {
            el.setAttribute(k, v);
        });
        return el;
    };

    const renderDonut = (container) => {
        const rawData = JSON.parse(container.dataset.series || '[]');
        container.innerHTML = '';

        const total = rawData.reduce((sum, item) => sum + (item.value || 0), 0);
        const chartData = total === 0 ? [{ label: '', value: 0, color: CONFIG.defaultColor }] : rawData;

        const svg = createNode('svg', {
            viewBox: `0 0 ${CONFIG.size} ${CONFIG.size}`,
            class: 'w-full h-full transform transition-transform duration-500 ease-out scale-95 opacity-0',
            style: 'overflow: visible;' 
        });

        const segmentsGroup = createNode('g');
        const centerGroup = createNode('g', { class: 'pointer-events-none' });
        
        // Label Text (Atas - Nama Status)
        const labelText = createNode('text', {
            x: '50%', y: '45%', 
            'text-anchor': 'middle', 
            class: 'text-[10px] font-bold uppercase tracking-widest font-sans transition-colors duration-200'
        });

        // Value Text (Bawah - Angka)
        const valueText = createNode('text', {
            x: '50%', y: '60%', 
            'text-anchor': 'middle', 
            class: 'fill-slate-800 text-3xl font-extrabold font-sans transition-opacity duration-200'
        });

        const updateCenter = (label, value, color = null) => {
            labelText.textContent = label;
            valueText.textContent = value;
            
            if (color) {
                labelText.setAttribute('fill', color);
                labelText.style.opacity = '1';
                valueText.style.opacity = '1';
            } else {
                // Kosongkan/Sembunyikan jika tidak ada data (state awal/mouseleave)
                labelText.textContent = '';
                valueText.textContent = '';
            }
        };

        // Inisialisasi Kosong (Sesuai permintaan)
        updateCenter('', '');

        const center = CONFIG.size / 2;
        const radius = (CONFIG.size - CONFIG.strokeWidth) / 2;
        const circumference = 2 * Math.PI * radius;
        let offset = 0;

        chartData.forEach((item) => {
            const value = total === 0 ? 1 : (item.value || 0);
            const percent = value / (total === 0 ? 1 : total);
            
            // Skip render jika value 0 agar tidak ada titik warna
            if (item.value === 0 && total !== 0) return;

            const segmentLength = circumference * percent;
            const drawLength = Math.max(0, segmentLength - CONFIG.gap);

            const circle = createNode('circle', {
                cx: center,
                cy: center,
                r: radius,
                fill: 'none',
                stroke: item.color || '#3b82f6',
                'stroke-width': CONFIG.strokeWidth,
                'stroke-dasharray': `${drawLength} ${circumference - drawLength}`,
                'stroke-dashoffset': -offset,
                class: 'transition-all duration-300 ease-out cursor-pointer hover:opacity-80',
                style: `transform-origin: center; transform: rotate(-90deg);`
            });

            if (total > 0) {
                circle.addEventListener('mouseenter', () => {
                    circle.setAttribute('stroke-width', CONFIG.strokeWidth + 4);
                    updateCenter(item.label, item.value, item.color);
                });

                circle.addEventListener('mouseleave', () => {
                    circle.setAttribute('stroke-width', CONFIG.strokeWidth);
                    updateCenter('', ''); // Kembali kosong saat mouse keluar
                });
            }

            segmentsGroup.appendChild(circle);
            offset += segmentLength;
        });

        svg.appendChild(segmentsGroup);
        centerGroup.appendChild(labelText);
        centerGroup.appendChild(valueText);
        svg.appendChild(centerGroup);
        container.appendChild(svg);

        requestAnimationFrame(() => {
            svg.classList.remove('scale-95', 'opacity-0');
            svg.classList.add('scale-100', 'opacity-100');
        });
    };

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.portfolio-status-donut').forEach(renderDonut);
    });
})();