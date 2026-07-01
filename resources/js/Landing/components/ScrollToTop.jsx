import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ArrowUp } from 'lucide-react';

const ScrollToTop = () => {
    const [isVisible, setIsVisible] = useState(false);
    const [scrollProgress, setScrollProgress] = useState(0);
    const [showTooltip, setShowTooltip] = useState(false);

    useEffect(() => {
        const toggleVisibility = () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;

            setScrollProgress(scrolled);
            setIsVisible(window.scrollY > 300);
        };

        window.addEventListener('scroll', toggleVisibility);
        return () => window.removeEventListener('scroll', toggleVisibility);
    }, []);

    const scrollToTop = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };

    // SVG circle params
    const size = 44;
    const radius = 18;
    const circumference = 2 * Math.PI * radius;
    const strokeDashoffset = circumference - (scrollProgress / 100) * circumference;

    return (
        <AnimatePresence>
            {isVisible && (
                <motion.div
                    initial={{ opacity: 0, scale: 0.5, y: 20 }}
                    animate={{ opacity: 1, scale: 1, y: 0 }}
                    exit={{ opacity: 0, scale: 0.5, y: 20 }}
                    transition={{ type: 'spring', stiffness: 300, damping: 25 }}
                    className="fixed bottom-6 right-6 z-50"
                >
                    {/* Tooltip */}
                    <AnimatePresence>
                        {showTooltip && (
                            <motion.div
                                initial={{ opacity: 0, y: 4, x: '-50%' }}
                                animate={{ opacity: 1, y: 0, x: '-50%' }}
                                exit={{ opacity: 0, y: 4, x: '-50%' }}
                                className="absolute bottom-[calc(100%+8px)] left-1/2 whitespace-nowrap bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-xl px-3 py-1.5 text-xs font-semibold text-gray-900 dark:text-white shadow-xl pointer-events-none"
                            >
                                Kembali ke atas
                                <div className="absolute top-full left-1/2 -translate-x-1/2 border-4 border-transparent border-t-white/50 dark:border-t-white/10" />
                            </motion.div>
                        )}
                    </AnimatePresence>

                    <motion.button
                        onClick={scrollToTop}
                        onMouseEnter={() => setShowTooltip(true)}
                        onMouseLeave={() => setShowTooltip(false)}
                        whileHover={{ scale: 1.08 }}
                        whileTap={{ scale: 0.92 }}
                        className="relative w-11 h-11 rounded-full bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-gray-200/80 dark:border-white/12 shadow-[0_8px_30px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_30px_rgba(0,0,0,0.5)] flex items-center justify-center group focus:outline-none focus:ring-2 focus:ring-[#F53003]/50"
                        aria-label="Scroll to top"
                    >
                        {/* Progress ring */}
                        <svg
                            className="absolute inset-0 w-full h-full -rotate-90"
                            viewBox={`0 0 ${size} ${size}`}
                        >
                            {/* Track */}
                            <circle
                                cx={size / 2}
                                cy={size / 2}
                                r={radius}
                                fill="none"
                                stroke="currentColor"
                                strokeWidth="2"
                                className="text-gray-200 dark:text-white/8"
                            />
                            {/* Progress */}
                            <circle
                                cx={size / 2}
                                cy={size / 2}
                                r={radius}
                                fill="none"
                                stroke="url(#scrollGradient)"
                                strokeWidth="2.5"
                                strokeLinecap="round"
                                strokeDasharray={circumference}
                                strokeDashoffset={strokeDashoffset}
                                style={{ transition: 'stroke-dashoffset 0.15s ease' }}
                            />
                            <defs>
                                <linearGradient id="scrollGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%" stopColor="#F53003" />
                                    <stop offset="100%" stopColor="#f59e0b" />
                                </linearGradient>
                            </defs>
                        </svg>

                        {/* Arrow icon */}
                        <motion.div
                            animate={{ y: [0, -2, 0] }}
                            transition={{ repeat: Infinity, duration: 2, ease: 'easeInOut' }}
                        >
                            <ArrowUp className="w-4 h-4 text-gray-600 dark:text-gray-300 group-hover:text-[#F53003] dark:group-hover:text-[#F53003] transition-colors duration-200 relative z-10" />
                        </motion.div>
                    </motion.button>
                </motion.div>
            )}
        </AnimatePresence>
    );
};

export default ScrollToTop;
