document.addEventListener('DOMContentLoaded', function() {
    if (window.location.pathname === '/payments') {
        const popup = document.createElement('div');
        popup.style.position = 'fixed';
        popup.style.top = '0';
        popup.style.left = '0';
        popup.style.width = '100vw';
        popup.style.height = '100vh';
        popup.style.background = 'rgba(0,0,0,0.5)';
        popup.style.display = 'flex';
        popup.style.alignItems = 'center';
        popup.style.justifyContent = 'center';
        popup.style.zIndex = '9999';
        popup.innerHTML = `
            <div style="background: white; padding: 2rem 3rem; border-radius: 1rem; text-align: center; box-shadow: 0 2px 16px rgba(0,0,0,0.2);">
                <h2 style="font-size: 2rem; margin-bottom: 1rem;">Coming Soon</h2>
                <p style="font-size: 1.2rem;">Payment feature is coming soon!</p>
                <button id="close-popup" style="margin-top: 1.5rem; padding: 0.5rem 1.5rem; background: #2563eb; color: white; border: none; border-radius: 0.5rem; font-size: 1rem; cursor: pointer;">Close</button>
            </div>
        `;
        document.body.appendChild(popup);
        document.getElementById('close-popup').onclick = function() {
            popup.remove();
        };
    }
});
