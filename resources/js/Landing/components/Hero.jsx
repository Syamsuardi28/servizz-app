import React, { useState, useEffect } from 'react';
import { ArrowRight, CheckCircle2, Mail, Shield, Zap, CreditCard, ChevronDown, Wrench, Check } from 'lucide-react';
import SmartServiceHub from './SmartServiceHub';

const Hero = ({ loginUrl, registerUrl }) => {
    const [isMounted, setIsMounted] = useState(false);

    useEffect(() => {
        const timer = setTimeout(() => {
            setIsMounted(true);
        }, 1200); // Trigger right after loader finishes
        return () => clearTimeout(timer);
    }, []);

    return (
        <section className="relative min-h-screen flex items-center pt-24 pb-20 overflow-hidden bg-white dark:bg-[#0a0a0a] transition-colors duration-500">
            {/* Ambient Background Grid Overlay */}
            <SmartServiceHub />

            {/* Glowing blur backdrops for neobanking feel */}
            <div className="absolute top-[20%] left-[10%] w-[350px] h-[350px] rounded-full bg-[#F53003]/5 dark:bg-[#F53003]/8 blur-[100px] pointer-events-none" />
            <div className="absolute bottom-[10%] right-[5%] w-[450px] h-[450px] rounded-full bg-amber-400/5 dark:bg-amber-500/8 blur-[120px] pointer-events-none" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                <div className="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    
                    {/* ── Left Panel: Typography & Copy ── */}
                    <div className="lg:col-span-6 flex flex-col items-start text-left">
                        {/* Upper Badge */}
                        <div 
                            className={`transition-all duration-800 ease-out transform ${
                                isMounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'
                            }`}
                            style={{ transitionDelay: '100ms' }}
                        >
                            <span className="section-label mb-6">
                                <span className="relative flex w-2 h-2">
                                    <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#F53003] opacity-75" />
                                    <span className="relative inline-flex rounded-full h-2 w-2 bg-[#F53003]" />
                                </span>
                                Platform Jasa Profesional Terintegrasi
                            </span>
                        </div>

                        {/* Main Title Heading */}
                        <h1 
                            className={`text-5xl md:text-6xl xl:text-7xl font-extrabold tracking-tight text-gray-900 dark:text-white mb-6 leading-[1.1] transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'
                            }`}
                            style={{ transitionDelay: '250ms' }}
                        >
                            Solusi Jasa <br />
                            <span className="text-gradient-primary">Aman & Terpantau</span>.
                        </h1>

                        {/* Description Paragraph */}
                        <p 
                            className={`text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8 leading-relaxed max-w-lg transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'
                            }`}
                            style={{ transitionDelay: '400ms' }}
                        >
                            Temukan teknisi handal, pantau progres secara{' '}
                            <span className="text-[#F53003] font-bold">real-time</span>, dan tetap terhubung melalui{' '}
                            <span className="text-[#F53003] font-bold">notifikasi cerdas</span>.
                        </p>

                        {/* CTA Row */}
                        <div 
                            className={`flex flex-col sm:flex-row gap-4 w-full sm:w-auto mb-10 transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'
                            }`}
                            style={{ transitionDelay: '550ms' }}
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
                                className="inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl bg-gray-100 dark:bg-white/5 border border-gray-200/50 dark:border-white/10 text-gray-900 dark:text-white font-semibold text-base hover:bg-gray-200/60 dark:hover:bg-white/10 transition-all duration-300"
                            >
                                Masuk Akun
                            </a>
                        </div>

                        {/* Trust badging row */}
                        <div 
                            className={`flex flex-wrap items-center gap-4 text-xs md:text-sm text-gray-600 dark:text-gray-400 font-medium transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'
                            }`}
                            style={{ transitionDelay: '700ms' }}
                        >
                            {[
                                { icon: <CheckCircle2 className="w-4 h-4 text-[#F53003]" />, text: 'Social Login Google' },
                                { icon: <Shield className="w-4 h-4 text-[#F53003]" />, text: 'Dukungan Admin 24/7' },
                                { icon: <Zap className="w-4 h-4 text-[#F53003]" />, text: 'Proses Instan' },
                            ].map((badge, i) => (
                                <div key={i} className="flex items-center gap-2 bg-gray-100/50 dark:bg-white/[0.03] backdrop-blur-md px-3.5 py-2 rounded-full border border-gray-200/40 dark:border-white/[0.05]">
                                    {badge.icon}
                                    <span>{badge.text}</span>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* ── Right Panel: Neobanking Credit Card Stack ── */}
                    <div className="lg:col-span-6 relative h-[450px] lg:h-[500px] flex items-center justify-center pointer-events-auto">
                        <style>{`
                            @keyframes float-card-1 {
                                0%, 100% { transform: translateY(0px) rotate(-8deg); }
                                50% { transform: translateY(-10px) rotate(-6deg); }
                            }
                            @keyframes float-card-2 {
                                0%, 100% { transform: translateY(0px) rotate(8deg); }
                                50% { transform: translateY(8px) rotate(9deg); }
                            }
                            @keyframes float-widget-1 {
                                0%, 100% { transform: translateY(0px) scale(1); }
                                50% { transform: translateY(-6px) scale(1.02); }
                            }
                            @keyframes float-widget-2 {
                                0%, 100% { transform: translateY(0px) scale(1); }
                                50% { transform: translateY(6px) scale(0.98); }
                            }
                            .animate-card-1 {
                                animation: float-card-1 6s ease-in-out infinite;
                            }
                            .animate-card-2 {
                                animation: float-card-2 7s ease-in-out infinite;
                            }
                            .animate-widget-1 {
                                animation: float-widget-1 5s ease-in-out infinite;
                            }
                            .animate-widget-2 {
                                animation: float-widget-2 5.5s ease-in-out infinite;
                            }
                        `}</style>

                        {/* Center glowing core backdrop */}
                        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-gradient-radial from-[#F53003]/25 dark:from-[#F53003]/30 to-transparent rounded-full blur-[60px] pointer-events-none" />

                        {/* The Diagonal Card Stack */}
                        <div 
                            className={`relative w-full max-w-[420px] h-[280px] transition-all duration-1200 ease-out transform ${
                                isMounted ? 'opacity-100 scale-100 rotate-0' : 'opacity-0 scale-95 rotate-3 blur-md'
                            }`}
                            style={{ transitionDelay: '300ms' }}
                        >
                            {/* Card 2: Back card (Mitra Card - Sleek Frosted Glass) */}
                            <div className="animate-card-2 absolute inset-0 w-[340px] h-[210px] left-16 top-0 bg-gradient-to-br from-white/10 to-white/[0.02] dark:from-white/[0.04] dark:to-transparent backdrop-blur-xl border border-gray-200/20 dark:border-white/10 rounded-2xl p-5 shadow-xl flex flex-col justify-between hover:z-30 hover:border-amber-500/30 transition-all duration-300">
                                <div className="flex justify-between items-start">
                                    {/* Smart Chip SVG */}
                                    <svg className="w-10 h-8 text-amber-500/80 fill-current" viewBox="0 0 100 80">
                                        <rect width="100" height="80" rx="15" fill="rgba(255,255,255,0.05)" />
                                        <rect x="15" y="15" width="20" height="20" rx="5" />
                                        <rect x="40" y="15" width="20" height="20" rx="5" />
                                        <rect x="65" y="15" width="20" height="20" rx="5" />
                                        <rect x="15" y="45" width="20" height="20" rx="5" />
                                        <rect x="40" y="45" width="20" height="20" rx="5" />
                                        <rect x="65" y="45" width="20" height="20" rx="5" />
                                    </svg>
                                    <div className="flex gap-1.5 items-center">
                                        <Wrench className="w-5 h-5 text-amber-500" />
                                        <span className="text-[10px] font-black tracking-widest text-amber-500">MITRA</span>
                                    </div>
                                </div>
                                <div className="mt-4">
                                    <p className="text-xs font-mono tracking-widest text-gray-500 dark:text-gray-400">**** **** **** 8890</p>
                                    <div className="flex justify-between items-end mt-4">
                                        <div>
                                            <p className="text-[8px] uppercase tracking-wider text-gray-400">Cardholder</p>
                                            <p className="text-xs font-bold text-gray-800 dark:text-white">SERVIZZ MITRA TEKNISI</p>
                                        </div>
                                        {/* MasterCard Circle Symbol Mockup */}
                                        <div className="flex -space-x-2">
                                            <div className="w-6 h-6 rounded-full bg-red-500/60" />
                                            <div className="w-6 h-6 rounded-full bg-yellow-500/60" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {/* Card 1: Front card (Client Card - Servizz Fiery Orange) */}
                            <div className="animate-card-1 absolute inset-0 w-[340px] h-[210px] left-0 top-12 bg-gradient-to-br from-[#F53003] via-orange-500 to-amber-500 border border-white/20 rounded-2xl p-5 shadow-[0_20px_50px_rgba(245,48,3,0.35)] flex flex-col justify-between hover:z-30 hover:scale-105 transition-all duration-300">
                                <div className="flex justify-between items-start">
                                    {/* Smart Chip SVG */}
                                    <svg className="w-10 h-8 text-white/90 fill-current" viewBox="0 0 100 80">
                                        <rect width="100" height="80" rx="15" fill="rgba(255,255,255,0.15)" />
                                        <rect x="15" y="15" width="20" height="20" rx="5" />
                                        <rect x="40" y="15" width="20" height="20" rx="5" />
                                        <rect x="65" y="15" width="20" height="20" rx="5" />
                                        <rect x="15" y="45" width="20" height="20" rx="5" />
                                        <rect x="40" y="45" width="20" height="20" rx="5" />
                                        <rect x="65" y="45" width="20" height="20" rx="5" />
                                    </svg>
                                    <span className="text-[10px] font-black tracking-widest text-white bg-white/20 px-2.5 py-1 rounded-full">CLIENT</span>
                                </div>
                                <div className="mt-4 text-white">
                                    <p className="text-sm font-mono tracking-widest">4000 1234 5678 2026</p>
                                    <div className="flex justify-between items-end mt-4">
                                        <div>
                                            <p className="text-[8px] uppercase tracking-wider text-white/70">Cardholder</p>
                                            <p className="text-xs font-bold">SERVIZZ MEMBER</p>
                                        </div>
                                        {/* Visa Logo Mockup */}
                                        <span className="text-sm font-black italic tracking-tighter">Visa</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Floating Transaction/Status Widgets (Inspired by Sub1 Banking UI) */}
                        {/* Widget 1: Top Left - Order Assigned */}
                        <div 
                            className={`animate-widget-1 absolute top-4 left-6 xl:-left-4 bg-white/80 dark:bg-black/50 backdrop-blur-xl border border-gray-200/50 dark:border-white/10 rounded-2xl p-3 shadow-2xl flex items-center gap-3.5 min-w-[210px] transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-8'
                            }`}
                            style={{ transitionDelay: '500ms' }}
                        >
                            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/20 flex-shrink-0">
                                <Check className="w-5 h-5" />
                            </div>
                            <div>
                                <p className="text-xs font-black text-gray-900 dark:text-white leading-tight">Teknisi Ditugaskan</p>
                                <p className="text-[10px] text-gray-500 dark:text-gray-400 mt-0.5">Sedang Menuju Lokasi</p>
                            </div>
                            <span className="ml-auto w-2 h-2 rounded-full bg-blue-500 animate-pulse flex-shrink-0" />
                        </div>

                        {/* Widget 2: Bottom Right - Tawar Sepakat */}
                        <div 
                            className={`animate-widget-2 absolute bottom-6 right-6 xl:-right-4 bg-white/80 dark:bg-black/50 backdrop-blur-xl border border-gray-200/50 dark:border-white/10 rounded-2xl p-3.5 shadow-2xl flex items-center gap-3.5 min-w-[196px] transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'
                            }`}
                            style={{ transitionDelay: '700ms' }}
                        >
                            <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-[#F53003] to-amber-500 flex items-center justify-center text-white shadow-lg shadow-[#F53003]/20 flex-shrink-0">
                                <CreditCard className="w-4.5 h-4.5" />
                            </div>
                            <div>
                                <p className="text-xs font-black text-gray-900 dark:text-white leading-tight">Negosiasi Berhasil</p>
                                <p className="text-[10px] text-emerald-500 dark:text-emerald-400 font-bold mt-0.5">Rp 150.000 (Sepakat)</p>
                            </div>
                        </div>

                        {/* Widget 3: Middle Right - Rating */}
                        <div 
                            className={`absolute top-[40%] -right-8 xl:-right-12 bg-white/80 dark:bg-black/50 backdrop-blur-xl border border-gray-200/50 dark:border-white/10 rounded-2xl px-4 py-3 shadow-2xl flex items-center gap-3 transition-all duration-1000 ease-out transform ${
                                isMounted ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'
                            }`}
                            style={{ transitionDelay: '900ms' }}
                        >
                            <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/20">
                                <CheckCircle2 className="w-5 h-5" />
                            </div>
                            <div>
                                <p className="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wide">Mitra Terverifikasi</p>
                                <p className="text-sm font-black text-gradient-primary">Rating 4.9/5</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Bottom Scroll indicator */}
                <div 
                    className={`absolute bottom-6 left-1/2 -translate-x-1/2 flex flex-col items-center gap-1.5 transition-opacity duration-1000 ${
                        isMounted ? 'opacity-100' : 'opacity-0'
                    }`}
                    style={{ transitionDelay: '1100ms' }}
                >
                    <span className="text-[9px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Scroll</span>
                    <ChevronDown className="w-4 h-4 text-gray-400 dark:text-gray-500 animate-bounce" />
                </div>
            </div>
        </section>
    );
};

export default Hero;
