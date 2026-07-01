import React, { useRef, useEffect } from 'react';
import { motion, useMotionValue, useTransform, useSpring } from 'framer-motion';
import { ArrowRight, CheckCircle2, Mail, Bell, TrendingUp, Users, ChevronDown, Shield, Zap } from 'lucide-react';

const Hero = ({ loginUrl, registerUrl }) => {
    const containerRef = useRef(null);

    // Mouse parallax for background orbs
    const mouseX = useMotionValue(0);
    const mouseY = useMotionValue(0);
    const springConfig = { stiffness: 50, damping: 20 };
    const orbX = useSpring(useTransform(mouseX, [0, 1], [-30, 30]), springConfig);
    const orbY = useSpring(useTransform(mouseY, [0, 1], [-20, 20]), springConfig);
    const orb2X = useSpring(useTransform(mouseX, [0, 1], [20, -20]), springConfig);
    const orb2Y = useSpring(useTransform(mouseY, [0, 1], [15, -15]), springConfig);

    useEffect(() => {
        const handleMouseMove = (e) => {
            const { clientX, clientY } = e;
            const { innerWidth, innerHeight } = window;
            mouseX.set(clientX / innerWidth);
            mouseY.set(clientY / innerHeight);
        };
        window.addEventListener('mousemove', handleMouseMove);
        return () => window.removeEventListener('mousemove', handleMouseMove);
    }, [mouseX, mouseY]);

    const headingWords = ['Solusi', 'Jasa', 'Aman', '&', 'Terpantau.'];

    const containerVariants = {
        hidden: {},
        visible: { transition: { staggerChildren: 0.08 } }
    };
    const wordVariants = {
        hidden: { opacity: 0, y: 30, filter: 'blur(4px)' },
        visible: { opacity: 1, y: 0, filter: 'blur(0px)', transition: { duration: 0.5, ease: [0.25, 0.46, 0.45, 0.94] } }
    };

    return (
        <section ref={containerRef} className="relative pt-32 pb-24 lg:pt-48 lg:pb-36 overflow-hidden">
            {/* ── Background layers ── */}
            <div className="absolute inset-0 -z-10">
                {/* Base gradient */}
                <div className="absolute inset-0 bg-gradient-to-b from-orange-50/60 via-white to-white dark:from-[#120200]/60 dark:via-[#0a0a0a] dark:to-[#0a0a0a]" />

                {/* Primary orb — parallax */}
                <motion.div
                    style={{ x: orbX, y: orbY }}
                    className="absolute -top-32 -left-64 w-[700px] h-[700px] bg-gradient-radial from-[#F53003]/20 to-transparent dark:from-[#F53003]/12 rounded-full blur-[120px]"
                />
                {/* Secondary orb — parallax reverse */}
                <motion.div
                    style={{ x: orb2X, y: orb2Y }}
                    className="absolute -top-16 -right-64 w-[600px] h-[600px] bg-gradient-radial from-amber-400/15 to-transparent dark:from-amber-500/10 rounded-full blur-[130px]"
                />
                {/* Bottom orb */}
                <div className="absolute bottom-0 left-1/2 -translate-x-1/2 w-[800px] h-[300px] bg-gradient-radial from-[#F53003]/5 to-transparent dark:from-[#F53003]/8 blur-[80px]" />

                {/* Subtle grid lines */}
                <div className="absolute inset-0 opacity-[0.03] dark:opacity-[0.05]"
                    style={{
                        backgroundImage: 'linear-gradient(rgba(0,0,0,1) 1px, transparent 1px), linear-gradient(90deg, rgba(0,0,0,1) 1px, transparent 1px)',
                        backgroundSize: '80px 80px'
                    }}
                />
            </div>

            <div className="container mx-auto px-6 max-w-7xl">
                <div className="grid lg:grid-cols-2 gap-16 lg:gap-10 items-center">

                    {/* ── Text Content ── */}
                    <div className="max-w-2xl">
                        {/* Badge */}
                        <motion.div
                            initial={{ opacity: 0, y: 16, scale: 0.95 }}
                            animate={{ opacity: 1, y: 0, scale: 1 }}
                            transition={{ duration: 0.5 }}
                            className="mb-7"
                        >
                            <span className="section-label">
                                <span className="relative flex w-2 h-2">
                                    <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#F53003] opacity-75" />
                                    <span className="relative inline-flex rounded-full h-2 w-2 bg-[#F53003]" />
                                </span>
                                Platform Jasa Profesional Terintegrasi
                            </span>
                        </motion.div>

                        {/* Heading — staggered word animation */}
                        <motion.h1
                            variants={containerVariants}
                            initial="hidden"
                            animate="visible"
                            className="text-5xl lg:text-7xl xl:text-8xl font-bold tracking-tight text-gray-900 dark:text-white mb-7 leading-[1.05]"
                        >
                            {headingWords.map((word, i) => (
                                <motion.span
                                    key={i}
                                    variants={wordVariants}
                                    className={`inline-block mr-4 ${
                                        word === 'Aman' ? 'text-gradient-primary' : ''
                                    } ${word === '&' ? 'text-gray-300 dark:text-gray-600' : ''}`}
                                >
                                    {word}
                                </motion.span>
                            ))}
                        </motion.h1>

                        {/* Subheading */}
                        <motion.p
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.6, delay: 0.5 }}
                            className="text-lg lg:text-xl text-gray-500 dark:text-gray-400 mb-9 leading-relaxed max-w-lg"
                        >
                            Temukan teknisi handal, pantau progres secara{' '}
                            <span className="text-gray-800 dark:text-gray-200 font-medium">real-time</span>, dan tetap terhubung melalui{' '}
                            <span className="text-gray-800 dark:text-gray-200 font-medium">notifikasi email otomatis</span>.
                        </motion.p>

                        {/* CTA Buttons */}
                        <motion.div
                            initial={{ opacity: 0, y: 20 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.6, delay: 0.65 }}
                            className="flex flex-col sm:flex-row gap-4 mb-10"
                        >
                            <a
                                href={registerUrl}
                                className="btn-primary inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl text-white font-semibold text-base"
                            >
                                Mulai Sekarang
                                <ArrowRight className="w-5 h-5" />
                            </a>
                            <a
                                href={loginUrl}
                                className="inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl bg-white dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-white font-semibold text-base hover:bg-gray-50 dark:hover:bg-white/10 hover:border-gray-300 dark:hover:border-white/20 hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg"
                            >
                                Masuk Akun
                            </a>
                        </motion.div>

                        {/* Trust badges */}
                        <motion.div
                            initial={{ opacity: 0, y: 16 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.6, delay: 0.8 }}
                            className="flex flex-wrap items-center gap-5 text-sm text-gray-500 dark:text-gray-400 font-medium"
                        >
                            {[
                                { icon: <CheckCircle2 className="w-4 h-4 text-emerald-500" />, text: 'Social Login Google' },
                                { icon: <Shield className="w-4 h-4 text-emerald-500" />, text: 'Dukungan Admin 24/7' },
                                { icon: <Zap className="w-4 h-4 text-emerald-500" />, text: 'Proses Instan' },
                            ].map((badge, i) => (
                                <div key={i} className="flex items-center gap-1.5">
                                    {badge.icon}
                                    <span>{badge.text}</span>
                                </div>
                            ))}
                        </motion.div>
                    </div>

                    {/* ── Dashboard Mockup ── */}
                    <motion.div
                        initial={{ opacity: 0, x: 60, scale: 0.95 }}
                        animate={{ opacity: 1, x: 0, scale: 1 }}
                        transition={{ duration: 0.9, delay: 0.2, ease: [0.25, 0.46, 0.45, 0.94] }}
                        className="relative lg:h-[620px] flex items-center justify-center lg:justify-end"
                    >
                        {/* Glow behind mockup */}
                        <div className="absolute inset-4 bg-gradient-to-br from-[#F53003]/15 via-amber-400/10 to-transparent dark:from-[#F53003]/20 dark:via-amber-500/10 blur-[60px] rounded-3xl" />

                        {/* Browser Frame */}
                        <div className="relative w-full max-w-[540px] bg-white dark:bg-[#141413] rounded-[24px] shadow-[0_32px_80px_rgba(0,0,0,0.12)] dark:shadow-[0_32px_80px_rgba(0,0,0,0.6)] border border-gray-200/80 dark:border-white/[0.08] overflow-hidden transform lg:rotate-[-1.5deg] hover:rotate-0 transition-transform duration-700">
                            {/* Browser chrome */}
                            <div className="h-11 border-b border-gray-100 dark:border-white/[0.06] flex items-center px-4 gap-3 bg-gray-50/80 dark:bg-white/[0.03]">
                                <div className="flex gap-1.5">
                                    <div className="w-3 h-3 rounded-full bg-[#FF5F57]" />
                                    <div className="w-3 h-3 rounded-full bg-[#FFBD2E]" />
                                    <div className="w-3 h-3 rounded-full bg-[#28CA41]" />
                                </div>
                                {/* URL bar */}
                                <div className="flex-1 mx-2 h-6 rounded-md bg-gray-100 dark:bg-white/5 border border-gray-200/50 dark:border-white/5 flex items-center px-2.5 gap-1.5">
                                    <div className="w-2.5 h-2.5 rounded-full bg-emerald-400/70" />
                                    <div className="h-2 w-28 bg-gray-300 dark:bg-white/15 rounded" />
                                </div>
                            </div>

                            {/* Dashboard content */}
                            <div className="p-4 sm:p-5 bg-gray-50/50 dark:bg-[#0d0d0c]">
                                {/* Top cards row */}
                                <div className="flex gap-3 mb-4">
                                    {/* Small stat card */}
                                    <div className="w-[38%] rounded-[14px] bg-white dark:bg-[#1c1c1b] shadow-sm border border-gray-100 dark:border-white/[0.06] p-3.5 flex flex-col justify-between">
                                        <div className="w-9 h-9 rounded-xl bg-orange-50 dark:bg-orange-500/15 flex items-center justify-center text-[#F53003]">
                                            <Users className="w-4 h-4" />
                                        </div>
                                        <div className="mt-3 space-y-1.5">
                                            <div className="h-2 w-12 bg-gray-200 dark:bg-white/10 rounded" />
                                            <div className="h-4 w-16 bg-gray-800 dark:bg-white/30 rounded font-bold" />
                                        </div>
                                    </div>
                                    {/* Main stat card — accent */}
                                    <div className="flex-1 rounded-[14px] bg-gradient-to-br from-[#F53003] to-[#b82500] shadow-lg shadow-[#F53003]/30 p-4 flex flex-col justify-between text-white relative overflow-hidden">
                                        <div className="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-xl" />
                                        <div className="absolute right-3 bottom-3 w-16 h-16 bg-white/5 rounded-full blur-lg" />
                                        <div className="relative z-10">
                                            <TrendingUp className="w-5 h-5 text-white/70 mb-2" />
                                            <div className="h-2.5 w-24 bg-white/25 rounded mb-1.5" />
                                            <div className="h-6 w-20 bg-white/35 rounded" />
                                        </div>
                                        <div className="relative z-10 flex items-center gap-1 mt-1">
                                            <span className="text-xs text-white/70">+12.5%</span>
                                            <div className="h-1.5 w-12 bg-white/20 rounded-full overflow-hidden">
                                                <div className="h-full w-[65%] bg-white/60 rounded-full" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {/* Timeline list */}
                                <div className="space-y-2.5">
                                    {[
                                        { status: 'Selesai', color: 'bg-emerald-100 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400' },
                                        { status: 'Proses', color: 'bg-blue-100 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400' },
                                        { status: 'Menunggu', color: 'bg-amber-100 dark:bg-amber-500/15 text-amber-600 dark:text-amber-400' },
                                    ].map((item, i) => (
                                        <div key={i} className="h-[52px] w-full rounded-[12px] bg-white dark:bg-[#1c1c1b] shadow-sm border border-gray-100/80 dark:border-white/[0.05] flex items-center px-3.5 gap-3">
                                            <div className="w-8 h-8 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-white/10 dark:to-white/5" />
                                            <div className="flex-1 space-y-1.5">
                                                <div className="h-2 w-28 bg-gray-200 dark:bg-white/15 rounded" />
                                                <div className="h-1.5 w-20 bg-gray-100 dark:bg-white/8 rounded" />
                                            </div>
                                            <span className={`text-[10px] font-semibold px-2.5 py-1 rounded-full ${item.color}`}>
                                                {item.status}
                                            </span>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Floating card 1 — Teknisi Berangkat */}
                        <motion.div
                            animate={{ y: [0, -14, 0] }}
                            transition={{ repeat: Infinity, duration: 4.5, ease: 'easeInOut' }}
                            className="absolute -bottom-4 -left-4 lg:bottom-12 lg:-left-14 bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-2xl p-4 shadow-[0_20px_50px_rgba(0,0,0,0.12)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex items-center gap-3.5 min-w-[210px]"
                        >
                            <div className="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 flex-shrink-0">
                                <CheckCircle2 className="w-5 h-5" />
                            </div>
                            <div>
                                <p className="text-sm font-bold text-gray-900 dark:text-white leading-tight">Teknisi Berangkat</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update Progres Baru</p>
                            </div>
                            <span className="ml-auto w-2 h-2 rounded-full bg-blue-500 animate-pulse flex-shrink-0" />
                        </motion.div>

                        {/* Floating card 2 — Notifikasi Email */}
                        <motion.div
                            animate={{ y: [0, 14, 0] }}
                            transition={{ repeat: Infinity, duration: 5.5, ease: 'easeInOut', delay: 1 }}
                            className="absolute -top-4 -right-4 lg:top-16 lg:-right-10 bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-2xl p-4 shadow-[0_20px_50px_rgba(0,0,0,0.12)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex items-center gap-3.5 min-w-[196px]"
                        >
                            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#F53003] to-amber-500 flex items-center justify-center text-white shadow-lg shadow-[#F53003]/30 flex-shrink-0">
                                <Mail className="w-4.5 h-4.5" />
                            </div>
                            <div>
                                <p className="text-sm font-bold text-gray-900 dark:text-white leading-tight">Notifikasi Email</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Terkirim Otomatis</p>
                            </div>
                        </motion.div>

                        {/* Floating card 3 — Statistics */}
                        <motion.div
                            animate={{ y: [0, -10, 0] }}
                            transition={{ repeat: Infinity, duration: 6, ease: 'easeInOut', delay: 2 }}
                            className="absolute top-1/2 -left-6 lg:-left-20 bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-2xl px-4 py-3 shadow-[0_20px_50px_rgba(0,0,0,0.12)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.5)] flex items-center gap-3"
                        >
                            <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                                <TrendingUp className="w-4 h-4" />
                            </div>
                            <div>
                                <p className="text-xs text-gray-500 dark:text-gray-400">Kepuasan</p>
                                <p className="text-base font-bold text-gradient-primary">98%</p>
                            </div>
                        </motion.div>
                    </motion.div>
                </div>

                {/* Scroll indicator */}
                <motion.div
                    initial={{ opacity: 0, y: 10 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 1.2, duration: 0.6 }}
                    className="flex flex-col items-center gap-2 mt-20 lg:mt-24"
                >
                    <span className="text-xs font-medium text-gray-400 dark:text-gray-600 uppercase tracking-widest">Scroll</span>
                    <motion.div
                        animate={{ y: [0, 6, 0] }}
                        transition={{ repeat: Infinity, duration: 1.8, ease: 'easeInOut' }}
                    >
                        <ChevronDown className="w-5 h-5 text-gray-400 dark:text-gray-600" />
                    </motion.div>
                </motion.div>
            </div>
        </section>
    );
};

export default Hero;
