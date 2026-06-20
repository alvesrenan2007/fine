<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimalist ERP Desktop</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

    <header class="header-main">
        <div class="header-main__brand">
            fine
        </div>
        <nav class="header-navigation">
            <ul class="header-navigation__list">
                <li><button class="header-navigation__btn header-navigation__btn--active">Dashboard</button></li>
                <li><button class="header-navigation__btn">Finance</button></li>
                <li><button class="header-navigation__btn">Inventory</button></li>
                <li><button class="header-navigation__btn">HR Modules</button></li>
            </ul>
        </nav>
    </header>

    <main class="app-shell">
        <header class="app-shell__header">
            <div>
                <h1 class="app-shell__title">Inventory Management</h1>
                <p class="app-shell__subtitle">Overview of active stock and pending orders.</p>
            </div>
            <div class="app-shell__actions">
                <button class="action-button action-button--secondary">Export Data</button>
                <button class="action-button action-button--primary">Create Order</button>
            </div>
        </header>

        <section class="app-shell__workspace">
            <div style="background: var(--color-light-blue); border-radius: var(--radius-block); padding: 2.4rem;">
                <h3 style="margin-bottom: 1.6rem; color: var(--color-primary-blue);">Stock Alerts</h3>
                <p style="font-size: 1.4rem; color: var(--color-text-muted);">3 items require immediate restocking.</p>
            </div>
            <div style="background: var(--color-light-blue); border-radius: var(--radius-block); padding: 2.4rem;">
                <h3 style="margin-bottom: 1.6rem; color: var(--color-primary-blue);">Pending Shipments</h3>
                <p style="font-size: 1.4rem; color: var(--color-text-muted);">12 orders queued for dispatch.</p>
            </div>
            <div style="background: var(--color-light-blue); border-radius: var(--radius-block); padding: 2.4rem;">
                <h3 style="margin-bottom: 1.6rem; color: var(--color-primary-blue);">System Status</h3>
                <p style="font-size: 1.4rem; color: var(--color-text-muted);">All ERP modules operational.</p>
            </div>
        </section>
    </main>

    <aside class="floating-mass">
        <button class="floating-mass__btn floating-mass__btn--secondary" title="Filter Selection">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
        </button>

        <button class="floating-mass__btn floating-mass__btn--primary" title="Mass Edit">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        </button>
    </aside>

</body>
</html>
