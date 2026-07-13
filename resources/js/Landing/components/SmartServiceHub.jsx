import React from 'react';
import { Smartphone, Laptop, Cpu, Wrench } from 'lucide-react';

const SmartServiceHub = () => {
    return (
        <div className="absolute inset-0 z-0 pointer-events-none overflow-hidden opacity-30 dark:opacity-40">
            <style>{`
                @keyframes pulse-slow {
                    0%, 100% {
                        opacity: 0.2;
                    }
                    50% {
                        opacity: 0.6;
                    }
                }
                @keyframes dash {
                    to {
                        stroke-dashoffset: -40;
                    }
                }
                @keyframes float-slow {
                    0%, 100% {
                        transform: translateY(0px) rotate(0deg);
                    }
                    50% {
                        transform: translateY(-8px) rotate(2deg);
                    }
                }
                @keyframes float-slower {
                    0%, 100% {
                        transform: translateY(0px) rotate(0deg);
                    }
                    50% {
                        transform: translateY(8px) rotate(-2deg);
                    }
                }
                .animate-pulse-slow {
                    animation: pulse-slow 4s ease-in-out infinite;
                }
                .animate-dash {
                    stroke-dasharray: 8, 12;
                    animation: dash 15s linear infinite;
                }
                .animate-float-slow {
                    animation: float-slow 8s ease-in-out infinite;
                }
                .animate-float-slower {
                    animation: float-slower 10s ease-in-out infinite;
                }
            `}</style>

            {/* Background Grid Mesh */}
            <div className="absolute inset-0 opacity-[0.06] dark:opacity-[0.04] bg-[linear-gradient(to_right,#808080_1px,transparent_1px),linear-gradient(to_bottom,#808080_1px,transparent_1px)] bg-[size:32px_32px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_50%,#000_70%,transparent_100%)]"></div>

            {/* SVG Connecting Node Grid */}
            <svg 
                className="absolute inset-0 w-full h-full" 
                xmlns="http://www.w3.org/2000/svg"
            >
                {/* Connecting Lines */}
                <path 
                    className="animate-dash"
                    d="M-100,200 L300,100 L450,300 L900,150 L1200,450 M200,600 L500,400 L800,700 L1100,500 L1400,650" 
                    stroke="rgba(245,48,3,0.12)" 
                    strokeWidth="1.5" 
                    fill="none" 
                />
                <path 
                    className="animate-dash"
                    d="M150,150 L350,450 L750,250 L1050,600" 
                    stroke="rgba(245,48,3,0.08)" 
                    strokeWidth="1.5" 
                    fill="none" 
                />

                {/* Glowing Grid Dots */}
                <circle cx="300" cy="100" r="3" className="fill-[#F53003] animate-pulse-slow" />
                <circle cx="450" cy="300" r="4" className="fill-amber-500 animate-pulse-slow" />
                <circle cx="900" cy="150" r="3.5" className="fill-[#F53003] animate-pulse-slow" style={{ animationDelay: '1.5s' }} />
                <circle cx="500" cy="400" r="3" className="fill-amber-500 animate-pulse-slow" style={{ animationDelay: '0.8s' }} />
                <circle cx="800" cy="700" r="5" className="fill-[#F53003] animate-pulse-slow" style={{ animationDelay: '2.2s' }} />
                <circle cx="1100" cy="500" r="3" className="fill-orange-400 animate-pulse-slow" style={{ animationDelay: '1s' }} />
            </svg>

            {/* Floating Tech Badges (CSS-animated, 0% CPU Overhead) */}
            <div className="absolute top-[18%] left-[10%] xl:left-[15%] animate-float-slow hidden md:flex items-center justify-center w-12 h-12 rounded-2xl bg-white/5 dark:bg-black/20 border border-white/10 shadow-xl backdrop-blur-md">
                <Smartphone className="w-5 h-5 text-[#F53003]" />
            </div>
            <div className="absolute top-[15%] right-[20%] animate-float-slower hidden xl:flex items-center justify-center w-14 h-14 rounded-2xl bg-white/5 dark:bg-black/20 border border-white/10 shadow-xl backdrop-blur-md">
                <Laptop className="w-6 h-6 text-amber-500" />
            </div>
            <div className="absolute bottom-[25%] left-[25%] animate-float-slower hidden lg:flex items-center justify-center w-12 h-12 rounded-2xl bg-white/5 dark:bg-black/20 border border-white/10 shadow-xl backdrop-blur-md">
                <Cpu className="w-5 h-5 text-orange-500" />
            </div>
            <div className="absolute bottom-[20%] right-[35%] animate-float-slow hidden md:flex items-center justify-center w-13 h-13 rounded-2xl bg-white/5 dark:bg-black/20 border border-white/10 shadow-xl backdrop-blur-md">
                <Wrench className="w-5.5 h-5.5 text-[#F53003]" />
            </div>
        </div>
    );
};

export default SmartServiceHub;
