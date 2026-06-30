import React from 'react';
import { createRoot } from 'react-dom/client';
import App from './Landing/App';

const container = document.getElementById('landing-app');

if (container) {
    const loginUrl = container.dataset.loginUrl;
    const registerUrl = container.dataset.registerUrl;
    const dashboardUrl = container.dataset.dashboardUrl;
    const isAuthenticated = container.dataset.isAuthenticated === 'true';

    const root = createRoot(container);
    root.render(
        <React.StrictMode>
            <App 
                loginUrl={loginUrl} 
                registerUrl={registerUrl} 
                dashboardUrl={dashboardUrl}
                isAuthenticated={isAuthenticated}
            />
        </React.StrictMode>
    );
}
