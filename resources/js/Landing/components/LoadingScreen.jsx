import React, { useEffect, useState } from 'react';

const LoadingScreen = ({ onComplete }) => {
    const [isFadingOut, setIsFadingOut] = useState(false);

    useEffect(() => {
        // Prevent scrolling while loading
        document.body.style.overflow = 'hidden';

        // Fast but satisfying loading sequence (1.2s total)
        const fadeOutTimer = setTimeout(() => {
            setIsFadingOut(true);
        }, 1100);

        const completeTimer = setTimeout(() => {
            document.body.style.overflow = '';
            onComplete();
        }, 1500);

        return () => {
            clearTimeout(fadeOutTimer);
            clearTimeout(completeTimer);
            document.body.style.overflow = '';
        };
    }, [onComplete]);

    return (
        <div 
            className={`fixed inset-0 z-[9999] bg-[#0a0a0a] flex flex-col items-center justify-center transition-all duration-500 ease-in-out-expo ${
                isFadingOut ? 'opacity-0 scale-105 blur-md pointer-events-none' : 'opacity-100 scale-100'
            }`}
        >
            <style>{`
                @keyframes drawPath {
                    0% {
                        stroke-dashoffset: 200;
                        fill: rgba(245, 48, 3, 0);
                    }
                    60% {
                        stroke-dashoffset: 0;
                        fill: rgba(245, 48, 3, 0);
                        stroke: rgba(245, 48, 3, 1);
                    }
                    100% {
                        stroke-dashoffset: 0;
                        fill: rgba(245, 48, 3, 1);
                        stroke: rgba(245, 48, 3, 0);
                    }
                }
                @keyframes fillProgress {
                    0% {
                        transform: scaleX(0);
                    }
                    100% {
                        transform: scaleX(1);
                    }
                }
                .animate-loading-logo {
                    stroke-dasharray: 200;
                    animation: drawPath 1.2s cubic-bezier(0.4, 0, 0.2, 1) forwards;
                }
                .animate-progress-fill {
                    transform-origin: left center;
                    animation: fillProgress 1.0s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
                }
                .ease-in-out-expo {
                    transition-timing-function: cubic-bezier(0.16, 1, 0.3, 1);
                }
            `}</style>

            {/* SVG Logo (Letter 'S') */}
            <svg 
                className="w-24 h-24 mb-8 drop-shadow-[0_0_15px_rgba(245,48,3,0.4)]" 
                viewBox="0 0 100 100" 
                fill="none" 
                xmlns="http://www.w3.org/2000/svg"
            >
                <path 
                    className="animate-loading-logo"
                    d="M 70 30 C 70 20 60 15 50 15 C 40 15 30 20 30 30 C 30 40 40 45 50 50 C 60 55 70 60 70 70 C 70 80 60 85 50 85 C 40 85 30 80 30 70" 
                    stroke="#F53003" 
                    strokeWidth="8" 
                    strokeLinecap="round" 
                    strokeLinejoin="round" 
                />
            </svg>

            {/* Progress Bar Container */}
            <div className="w-48 h-1 bg-white/10 rounded-full overflow-hidden">
                <div className="animate-progress-fill w-full h-full bg-gradient-to-r from-[#F53003] to-[#f59e0b] shadow-[0_0_10px_#F53003]"></div>
            </div>
        </div>
    );
};

export default LoadingScreen;
