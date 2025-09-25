<div class="fi-login-footer mt-4">
    <div class="fi-login-actions flex flex-col sm:flex-row-reverse gap-3">
        <a href="/"
            class="fi-login-back w-full inline-flex items-center justify-center rounded-md border border-[#1b3985] px-4 py-2 font-medium text-[#1b3985] hover:bg-blue-50">
            {{ __('Kembali ke Beranda') }}
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('[data-fi-form] form, form.fi-form');
        if (!form) return;

        const submitButton = form.querySelector('button[type="submit"], [type="submit"].fi-btn');
        if (submitButton) {
            submitButton.textContent = 'Masuk';
            submitButton.classList.add('fi-login-submit', 'bg-[#fa7516]', 'hover:bg-[#e5670c]',
                'focus:ring-[#fa7516]', 'text-white', 'font-medium', 'px-4', 'py-2.5', 'rounded-md', 'shadow-sm');
        }

        const actionsContainer = submitButton?.closest('[data-fi-form-actions], .fi-form-actions');
        const footerActions = document.querySelector('.fi-login-actions');

        if (actionsContainer && footerActions && !footerActions.contains(actionsContainer)) {
            actionsContainer.classList.add('flex', 'flex-col', 'sm:flex-row-reverse', 'gap-3', 'pt-2');
            footerActions.prepend(actionsContainer);
        }
    });
</script>
