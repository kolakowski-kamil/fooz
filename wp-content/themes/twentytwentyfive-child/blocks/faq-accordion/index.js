import './index.scss';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.faq-accordion-block').forEach(block => {
        const iconStyle = block.dataset.icon || 'plus_minus';

        block.querySelectorAll('.faq-question').forEach(btn => {
            const answer = document.getElementById(btn.getAttribute('aria-controls'));

            answer.style.maxHeight = '0';
            btn.setAttribute('aria-expanded', 'false');
            toggleIcons(btn, iconStyle, false);

            btn.addEventListener('click', () => {
                const isOpen = btn.getAttribute('aria-expanded') === 'true';
                const newOpen = !isOpen;
                btn.setAttribute('aria-expanded', newOpen);

                if (newOpen) {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                } else {
                    answer.style.maxHeight = '0';
                }

                toggleIcons(btn, iconStyle, newOpen);
            });
        });
    });
});

function toggleIcons(btn, style, isOpen) {
    const plus = btn.querySelector('.icon-plus');
    const minus = btn.querySelector('.icon-minus');
    const arrow = btn.querySelector('.icon-arrow');

    if (style === 'up_down' && arrow) {
        arrow.style.transform = isOpen ? 'rotate(90deg)' : 'rotate(-90deg)';
    } else {
        if (plus) plus.style.display = isOpen ? 'none' : 'inline';
        if (minus) minus.style.display = isOpen ? 'inline' : 'none';
    }
}