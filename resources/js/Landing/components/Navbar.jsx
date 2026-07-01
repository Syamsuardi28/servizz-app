import React, { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, ArrowRight, ChevronDown } from 'lucide-react';
import { cn } from '../utils';

const Navbar = ({ loginUrl, registerUrl, dashboardUrl, isAuthenticated }) => {
    const [scrolled, setScrolled] = useState(false);
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);
    const [activeLink, setActiveLink] = useState('');

    useEffect(() => {
        // Scroll listener
        const handleScroll = () => {
            setScrolled(window.scrollY > 20);
        };
        window.addEventListener('scroll', handleScroll);
        
        // Entry animation
        setTimeout(() => {
            import('animejs').then((animeModule) => {
                const anime = animeModule.default;
                anime({
                    targets: '.navbar-container',
                    opacity: [0, 1],
                    translateY: [-20, 0],
                    duration: 1000,
                    easing: 'easeOutExpo',
                });
            });
        }, 1500); // Wait for preloader

        return () => window.removeEventListener('scroll', handleScroll);
    }, []);

    const navLinks = [
        { name: 'Home', href: '#' },
        { name: 'Features', href: '#features' },
        { name: 'How It Works', href: '#how-it-works' },
        { name: 'FAQ', href: '#faq' },
    ];

    return (
        <header
            className={cn(
                'navbar-container opacity-0 fixed top-0 inset-x-0 z-50 transition-all duration-500 ease-out',
                scrolled
                    ? 'bg-white/80 dark:bg-[#0a0a0a]/80 backdrop-blur-xl backdrop-saturate-[1.8] border-b border-gray-200/60 dark:border-white/[0.07] py-3 shadow-[0_4px_24px_rgba(0,0,0,0.06)] dark:shadow-[0_4px_24px_rgba(0,0,0,0.3)]'
                    : 'bg-transparent py-5'
            )}
        >
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="flex items-center justify-between">

                    {/* Logo */}
                    <a href="#" className="flex items-center gap-2.5 group">
                        <div className="relative w-9 h-9 rounded-xl bg-gradient-to-br from-[#F53003] to-[#c52400] flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-[#F53003]/30 group-hover:shadow-[#F53003]/50 transition-all duration-300 group-hover:scale-105">
                            <span className="relative z-10">S</span>
                            <div className="absolute inset-0 rounded-xl bg-gradient-to-tr from-white/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                        </div>
                        <span className="text-xl font-bold tracking-tight text-gray-900 dark:text-white group-hover:text-[#F53003] dark:group-hover:text-[#F53003] transition-colors duration-300">
                            Servizz
                        </span>
                    </a>

                    {/* Desktop Navigation */}
                    <nav className="hidden md:flex items-center gap-1">
                        {navLinks.map((link) => (
                            <a
                                key={link.name}
                                href={link.href}
                                onMouseEnter={() => setActiveLink(link.name)}
                                onMouseLeave={() => setActiveLink('')}
                                className="relative px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors duration-200 group rounded-lg hover:bg-gray-100/50 dark:hover:bg-white/5"
                            >
                                {link.name}
                                {/* Animated underline */}
                                <span className="absolute bottom-1 left-4 right-4 h-[1.5px] bg-gradient-to-r from-[#F53003] to-amber-500 rounded-full scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left" />
                            </a>
                        ))}
                    </nav>

                    {/* Desktop CTA */}
                    <div className="hidden md:flex items-center gap-3">
                        {isAuthenticated ? (
                            <a
                                href={dashboardUrl}
                                className="flex items-center gap-2 px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-semibold rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-all duration-300 hover:-translate-y-0.5 hover:shadow-lg"
                            >
                                Dashboard
                                <ArrowRight className="w-4 h-4" />
                            </a>
                        ) : (
                            <>
                                <a
                                    href={loginUrl}
                                    className="px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white rounded-xl hover:bg-gray-100/70 dark:hover:bg-white/5 transition-all duration-200"
                                >
                                    Log in
                                </a>
                                {registerUrl && (
                                    <a
                                        href={registerUrl}
                                        className="btn-primary flex items-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold"
                                    >
                                        Daftar Sekarang
                                        <ArrowRight className="w-4 h-4" />
                                    </a>
                                )}
                            </>
                        )}
                    </div>

                    {/* Mobile Menu Button */}
                    <button
                        className="md:hidden relative p-2.5 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/10 transition-all duration-200"
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                        aria-label="Toggle menu"
                    >
                        <AnimatePresence mode="wait">
                            {mobileMenuOpen ? (
                                <motion.div key="close" initial={{ rotate: -90, opacity: 0 }} animate={{ rotate: 0, opacity: 1 }} exit={{ rotate: 90, opacity: 0 }} transition={{ duration: 0.15 }}>
                                    <X className="w-5 h-5" />
                                </motion.div>
                            ) : (
                                <motion.div key="open" initial={{ rotate: 90, opacity: 0 }} animate={{ rotate: 0, opacity: 1 }} exit={{ rotate: -90, opacity: 0 }} transition={{ duration: 0.15 }}>
                                    <Menu className="w-5 h-5" />
                                </motion.div>
                            )}
                        </AnimatePresence>
                    </button>
                </div>
            </div>

            {/* Mobile Menu */}
            <AnimatePresence>
                {mobileMenuOpen && (
                    <motion.div
                        initial={{ opacity: 0, y: -8 }}
                        animate={{ opacity: 1, y: 0 }}
                        exit={{ opacity: 0, y: -8 }}
                        transition={{ duration: 0.2, ease: 'easeOut' }}
                        className="md:hidden mt-2 mx-4 rounded-2xl bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-gray-200/60 dark:border-white/10 shadow-xl overflow-hidden"
                    >
                        <div className="px-4 py-4 flex flex-col gap-1">
                            {navLinks.map((link, i) => (
                                <motion.a
                                    key={link.name}
                                    href={link.href}
                                    initial={{ opacity: 0, x: -10 }}
                                    animate={{ opacity: 1, x: 0 }}
                                    transition={{ delay: i * 0.05 }}
                                    className="flex items-center gap-2 px-4 py-3 text-sm font-medium text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-100/80 dark:hover:bg-white/8 hover:text-[#F53003] dark:hover:text-[#F53003] transition-all duration-200"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    <span className="w-1.5 h-1.5 rounded-full bg-gray-300 dark:bg-gray-600 group-hover:bg-[#F53003]" />
                                    {link.name}
                                </motion.a>
                            ))}
                            <div className="flex flex-col gap-2 pt-3 mt-2 border-t border-gray-100 dark:border-white/10">
                                {isAuthenticated ? (
                                    <a
                                        href={dashboardUrl}
                                        className="w-full py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-center font-semibold rounded-xl text-sm"
                                    >
                                        Buka Dashboard
                                    </a>
                                ) : (
                                    <>
                                        <a
                                            href={loginUrl}
                                            className="w-full py-3 text-center text-sm font-medium border border-gray-200 dark:border-white/15 rounded-xl text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                                        >
                                            Log in
                                        </a>
                                        {registerUrl && (
                                            <a
                                                href={registerUrl}
                                                className="btn-primary w-full py-3 text-white text-center font-semibold rounded-xl text-sm"
                                            >
                                                Daftar Sekarang
                                            </a>
                                        )}
                                    </>
                                )}
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </header>
    );
};

export default Navbar;
