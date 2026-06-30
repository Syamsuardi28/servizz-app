import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

// Setup Alpine
window.Alpine = Alpine;
Alpine.start();

// Setup Lucide Icons
document.addEventListener("DOMContentLoaded", () => {
    createIcons({ icons });
});