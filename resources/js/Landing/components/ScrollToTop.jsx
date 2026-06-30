import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ArrowUp } from 'lucide-react';
import { cn } from '../utils';

const ScrollToTop = () => {
    const [isVisible, setIsVisible] = useState(false);
    const [scrollProgress, setScrollProgress] = useState(0);

    useEffect(() => {
        const toggleVisibility = () => {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            
            setScrollProgress(scrolled);
            
            if (window.scrollY > 300) {
                setIsVisible(true);
            } else {
                setIsVisible(false);
            }
        };

        window.addEventListener("scroll", toggleVisibility);
        return () => window.removeEventListener("scroll", toggleVisibility);
    }, []);

    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    };

    return (
        <AnimatePresence>
            {isVisible && (
                <motion.button
                    initial={{ opacity: 0, scale: 0.5 }}
                    animate={{ opacity: 1, scale: 1 }}
                    exit={{ opacity: 0, scale: 0.5 }}
                    onClick={scrollToTop}
                    className="fixed bottom-6 right-6 z-50 p-3 rounded-full bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-gray-100 dark:border-gray-700 hover:-translate-y-1 transition-all group overflow-hidden focus:outline-none"
                    aria-label="Scroll to top"
                >
                    {/* SVG Progress Circle Background */}
                    <div className="absolute inset-0 z-0">
                        <svg className="w-full h-full transform -rotate-90">
                            <circle
                                cx="50%"
                                cy="50%"
                                r="48%"
                                className="fill-none stroke-gray-100 dark:stroke-gray-700"
                                strokeWidth="2"
                            />
                            <circle
                                cx="50%"
                                cy="50%"
                                r="48%"
                                className="fill-none stroke-[#F53003]"
                                strokeWidth="2"
                                strokeDasharray="100"
                                strokeDashoffset={100 - scrollProgress}
                            />
                        </svg>
                    </div>
                    
                    <ArrowUp className="w-5 h-5 relative z-10 group-hover:text-[#F53003] transition-colors" />
                </motion.button>
            )}
        </AnimatePresence>
    );
};

export default ScrollToTop;
