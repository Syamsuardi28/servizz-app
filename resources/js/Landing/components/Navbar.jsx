import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Menu, X, ArrowRight } from 'lucide-react';
import { cn } from '../utils';

const Navbar = ({ loginUrl, registerUrl, dashboardUrl, isAuthenticated }) => {
    const [scrolled, setScrolled] = useState(false);
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

    useEffect(() => {
        const handleScroll = () => {
            setScrolled(window.scrollY > 20);
        };
        window.addEventListener('scroll', handleScroll);
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
                'fixed top-0 inset-x-0 z-50 transition-all duration-300',
                scrolled ? 'bg-white/70 dark:bg-[#0a0a0a]/70 backdrop-blur-md border-b border-gray-200 dark:border-white/10 shadow-sm py-3' : 'bg-transparent py-5'
            )}
        >
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="flex items-center justify-between">
                    {/* Logo */}
                    <a href="#" className="flex items-center gap-2">
                        <div className="w-8 h-8 rounded-lg bg-[#F53003] flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-[#F53003]/30">
                            S
                        </div>
                        <span className="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Servizz
                        </span>
                    </a>

                    {/* Desktop Navigation */}
                    <nav className="hidden md:flex items-center gap-8">
                        {navLinks.map((link) => (
                            <a 
                                key={link.name} 
                                href={link.href} 
                                className="text-sm font-medium text-gray-600 hover:text-[#F53003] dark:text-gray-300 dark:hover:text-[#F53003] transition-colors"
                            >
                                {link.name}
                            </a>
                        ))}
                    </nav>

                    {/* Desktop CTA */}
                    <div className="hidden md:flex items-center gap-4">
                        {isAuthenticated ? (
                            <a 
                                href={dashboardUrl} 
                                className="flex items-center gap-2 px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-sm font-medium rounded-full hover:bg-gray-800 dark:hover:bg-gray-100 transition-all hover:-translate-y-0.5"
                            >
                                Dashboard
                                <ArrowRight className="w-4 h-4" />
                            </a>
                        ) : (
                            <>
                                <a 
                                    href={loginUrl} 
                                    className="text-sm font-medium text-gray-900 dark:text-white hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors"
                                >
                                    Log in
                                </a>
                                {registerUrl && (
                                    <a 
                                        href={registerUrl} 
                                        className="flex items-center gap-2 px-5 py-2.5 bg-[#F53003] text-white text-sm font-medium rounded-full hover:bg-[#e02a02] transition-all hover:-translate-y-0.5 shadow-lg shadow-[#F53003]/25"
                                    >
                                        Daftar Sekarang
                                    </a>
                                )}
                            </>
                        )}
                    </div>

                    {/* Mobile Menu Button */}
                    <button 
                        className="md:hidden p-2 text-gray-600 dark:text-gray-300"
                        onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
                    >
                        {mobileMenuOpen ? <X /> : <Menu />}
                    </button>
                </div>
            </div>

            {/* Mobile Menu */}
            <AnimatePresence>
                {mobileMenuOpen && (
                    <motion.div 
                        initial={{ opacity: 0, height: 0 }}
                        animate={{ opacity: 1, height: 'auto' }}
                        exit={{ opacity: 0, height: 0 }}
                        className="md:hidden bg-white dark:bg-[#0a0a0a] border-b border-gray-100 dark:border-white/10"
                    >
                        <div className="px-6 py-4 flex flex-col gap-4">
                            {navLinks.map((link) => (
                                <a 
                                    key={link.name} 
                                    href={link.href} 
                                    className="text-base font-medium text-gray-600 dark:text-gray-300 py-2 border-b border-gray-50 dark:border-white/5"
                                    onClick={() => setMobileMenuOpen(false)}
                                >
                                    {link.name}
                                </a>
                            ))}
                            <div className="flex flex-col gap-3 pt-2">
                                {isAuthenticated ? (
                                    <a 
                                        href={dashboardUrl} 
                                        className="w-full py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-center font-medium rounded-lg"
                                    >
                                        Buka Dashboard
                                    </a>
                                ) : (
                                    <>
                                        <a 
                                            href={loginUrl} 
                                            className="w-full py-3 text-center font-medium border border-gray-200 dark:border-white/20 rounded-lg text-gray-900 dark:text-white"
                                        >
                                            Log in
                                        </a>
                                        {registerUrl && (
                                            <a 
                                                href={registerUrl} 
                                                className="w-full py-3 bg-[#F53003] text-white text-center font-medium rounded-lg"
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
