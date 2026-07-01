import React, { useEffect, useRef } from 'react';
import anime from 'animejs';

const LoadingScreen = ({ onComplete }) => {
    const containerRef = useRef(null);

    useEffect(() => {
        // Prevent scrolling while loading
        document.body.style.overflow = 'hidden';

        const tl = anime.timeline({
            easing: 'easeOutExpo'
        });

        // 1. Line drawing animation of the SVG path
        tl.add({
            targets: '.loading-logo path',
            strokeDashoffset: [anime.setDashoffset, 0],
            easing: 'easeInOutSine',
            duration: 1500,
            delay: (el, i) => i * 150
        })
        // 2. Fill the logo and remove stroke
        .add({
            targets: '.loading-logo path',
            fill: 'rgba(245, 48, 3, 1)',
            stroke: 'rgba(245, 48, 3, 0)',
            duration: 500,
            easing: 'linear'
        }, '-=500')
        // 3. Progress bar scale
        .add({
            targets: '.progress-bar-fill',
            scaleX: [0, 1],
            transformOrigin: '0% 50%',
            duration: 800,
            easing: 'easeInOutQuart'
        }, '-=1000')
        // 4. Fade out everything and trigger onComplete
        .add({
            targets: containerRef.current,
            opacity: 0,
            scale: 1.1,
            filter: 'blur(10px)',
            duration: 800,
            easing: 'easeInExpo',
            complete: () => {
                document.body.style.overflow = '';
                onComplete();
            }
        });

        return () => {
            document.body.style.overflow = '';
        };
    }, [onComplete]);

    return (
        <div 
            ref={containerRef} 
            className="fixed inset-0 z-[9999] bg-[#0a0a0a] flex flex-col items-center justify-center pointer-events-none"
        >
            {/* SVG Logo (Letter 'S') */}
            <svg 
                className="loading-logo w-24 h-24 mb-8 drop-shadow-[0_0_15px_rgba(245,48,3,0.5)]" 
                viewBox="0 0 100 100" 
                fill="none" 
                xmlns="http://www.w3.org/2000/svg"
            >
                <path 
                    d="M 70 30 C 70 20 60 15 50 15 C 40 15 30 20 30 30 C 30 40 40 45 50 50 C 60 55 70 60 70 70 C 70 80 60 85 50 85 C 40 85 30 80 30 70" 
                    stroke="#F53003" 
                    strokeWidth="8" 
                    strokeLinecap="round" 
                    strokeLinejoin="round" 
                    fill="transparent"
                />
            </svg>

            {/* Progress Bar Container */}
            <div className="w-48 h-1 bg-white/10 rounded-full overflow-hidden">
                <div className="progress-bar-fill w-full h-full bg-gradient-to-r from-[#F53003] to-[#f59e0b] shadow-[0_0_10px_#F53003]" style={{ transform: 'scaleX(0)' }}></div>
            </div>
        </div>
    );
};

export default LoadingScreen;
