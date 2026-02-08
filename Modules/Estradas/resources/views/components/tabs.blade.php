@props(['defaultTab' => 0])

<div class="space-y-6">
    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            {{ $tabs }}
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        {{ $content }}
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    function showTab(targetId) {
        // Hide all panels
        tabPanels.forEach(panel => {
            panel.classList.add('hidden');
        });

        // Remove active state from all buttons
        tabButtons.forEach(button => {
            button.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
        });

        // Show target panel
        const targetPanel = document.querySelector(`[data-tab-panel="${targetId}"]`);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        // Activate target button
        const targetButton = document.querySelector(`[data-tab-target="${targetId}"]`);
        if (targetButton) {
            targetButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            targetButton.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        }
    }

    // Add click handlers
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-tab-target');
            showTab(targetId);
        });
    });

    // Show default tab
    const defaultTab = {{ $defaultTab }};
    if (tabButtons[defaultTab]) {
        const targetId = tabButtons[defaultTab].getAttribute('data-tab-target');
        showTab(targetId);
    }
});
</script>

