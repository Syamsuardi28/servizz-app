import React, { useRef, useEffect } from 'react';
import anime from 'animejs';
import { ArrowRight, CheckCircle2, Mail, TrendingUp, Users, ChevronDown, Shield, Zap } from 'lucide-react';
import SmartServiceHub from './SmartServiceHub';

const Hero = ({ loginUrl, registerUrl }) => {
    const heroRef = useRef(null);

    useEffect(() => {
        // Anime.js Timeline for Hero entry
        const tl = anime.timeline({
            easing: 'easeOutExpo',
        });

        // 1. Text reveal (character by character)
        const headingElement = document.querySelector('.hero-heading');
        if (headingElement) {
            headingElement.innerHTML = headingElement.textContent.replace(/\S/g, "<span class='letter inline-block opacity-0'>$&</span>");
            
            tl.add({
                targets: '.hero-heading .letter',
                opacity: [0, 1],
                translateY: [40, 0],
                translateZ: 0,
                rotateX: [-90, 0],
                filter: ['blur(10px)', 'blur(0px)'],
                duration: 1200,
                delay: (el, i) => 800 + 40 * i, // Delay to wait for preloader
            });
        }

        // 2. Subheading and Badges slide up
        tl.add({
            targets: '.hero-element',
            opacity: [0, 1],
            translateY: [20, 0],
            filter: ['blur(8px)', 'blur(0px)'],
            duration: 800,
            delay: anime.stagger(150),
        }, '-=800');

        // 3. Floating cards
        tl.add({
            targets: '.hero-card',
            opacity: [0, 1],
            scale: [0.9, 1],
            translateX: [30, 0],
            duration: 1000,
            delay: anime.stagger(200),
            complete: () => {
                // Add floating animation after entrance
                anime({
                    targets: '.hero-card',
                    translateY: [-10, 10],
                    direction: 'alternate',
                    loop: true,
                    duration: 3000,
                    easing: 'easeInOutSine',
                    delay: anime.stagger(500)
                });
            }
        }, '-=600');
        
        // 4. Scroll indicator bobbing
        anime({
            targets: '.hero-scroll-indicator',
            translateY: [0, 8],
            direction: 'alternate',
            loop: true,
            duration: 1200,
            easing: 'easeInOutSine'
        });

    }, []);

    return (
        <section ref={heroRef} className="relative min-h-screen flex items-center pt-20 pb-16 overflow-hidden">
            {/* ── 3D Interactive Background ── */}
            <SmartServiceHub />

            {/* Gradient overlay for text readability */}
            <div className="absolute inset-0 bg-gradient-to-r from-white/90 via-white/50 to-transparent dark:from-[#0a0a0a]/90 dark:via-[#0a0a0a]/50 dark:to-transparent z-0" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                <div className="grid lg:grid-cols-2 gap-16 lg:gap-10 items-center">
                    {/* ── Text Content ── */}
                    <div className="max-w-2xl">
                        {/* Badge */}
                        <div className="hero-element opacity-0 mb-7">
                            <span className="section-label">
                                <span className="relative flex w-2 h-2">
                                    <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#F53003] opacity-75" />
                                    <span className="relative inline-flex rounded-full h-2 w-2 bg-[#F53003]" />
                                </span>
                                Platform Jasa Profesional Terintegrasi
                            </span>
                        </div>

                        {/* Heading */}
                        <h1 className="hero-heading text-5xl lg:text-7xl xl:text-8xl font-bold tracking-tight text-gray-900 dark:text-white mb-7 leading-[1.05] [perspective:1000px]">
                            Solusi Jasa Aman & Terpantau.
                        </h1>

                        {/* Subheading */}
                        <p className="hero-element opacity-0 text-lg lg:text-xl text-gray-600 dark:text-gray-300 mb-9 leading-relaxed max-w-lg font-medium backdrop-blur-sm">
                            Temukan teknisi handal, pantau progres secara{' '}
                            <span className="text-[#F53003] font-bold">real-time</span>, dan tetap terhubung melalui{' '}
                            <span className="text-[#F53003] font-bold">notifikasi cerdas</span>.
                        </p>

                        {/* CTA Buttons */}
                        <div className="hero-element opacity-0 flex flex-col sm:flex-row gap-4 mb-10">
                            <a
                                href={registerUrl}
                                className="btn-primary inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl text-white font-semibold text-base"
                            >
                                Mulai Sekarang
                                <ArrowRight className="w-5 h-5" />
                            </a>
                            <a
                                href={loginUrl}
                                className="inline-flex justify-center items-center gap-2.5 px-8 py-4 rounded-2xl bg-white/20 dark:bg-white/5 backdrop-blur-md border border-gray-200/50 dark:border-white/10 text-gray-900 dark:text-white font-semibold text-base hover:bg-white/40 dark:hover:bg-white/10 transition-all duration-300"
                            >
                                Masuk Akun
                            </a>
                        </div>

                        {/* Trust badges */}
                        <div className="hero-element opacity-0 flex flex-wrap items-center gap-5 text-sm text-gray-700 dark:text-gray-300 font-medium">
                            {[
                                { icon: <CheckCircle2 className="w-4 h-4 text-[#F53003]" />, text: 'Social Login Google' },
                                { icon: <Shield className="w-4 h-4 text-[#F53003]" />, text: 'Dukungan Admin 24/7' },
                                { icon: <Zap className="w-4 h-4 text-[#F53003]" />, text: 'Proses Instan' },
                            ].map((badge, i) => (
                                <div key={i} className="flex items-center gap-2 bg-white/10 dark:bg-black/20 backdrop-blur-sm px-3 py-1.5 rounded-full border border-black/5 dark:border-white/5">
                                    {badge.icon}
                                    <span>{badge.text}</span>
                                </div>
                            ))}
                        </div>
                    </div>

                    {/* ── Glass Floating Cards (Mockup replacement) ── */}
                    <div className="relative h-[500px] flex items-center justify-center lg:justify-end hidden lg:flex">
                        
                        {/* Center decorative element */}
                        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-gradient-radial from-[#F53003]/20 to-transparent rounded-full blur-[40px] pointer-events-none" />

                        {/* Floating card 1 */}
                        <div className="hero-card opacity-0 absolute top-20 right-10 bg-white/80 dark:bg-black/40 backdrop-blur-xl border border-white/40 dark:border-white/10 rounded-2xl p-4 shadow-2xl flex items-center gap-3.5 min-w-[210px] z-10">
                            <div className="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 flex-shrink-0">
                                <CheckCircle2 className="w-5 h-5" />
                            </div>
                            <div>
                                <p className="text-sm font-bold text-gray-900 dark:text-white leading-tight">Teknisi Berangkat</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Update Progres Baru</p>
                            </div>
                            <span className="ml-auto w-2 h-2 rounded-full bg-blue-500 animate-pulse flex-shrink-0" />
                        </div>

                        {/* Floating card 2 */}
                        <div className="hero-card opacity-0 absolute bottom-32 left-10 bg-white/80 dark:bg-black/40 backdrop-blur-xl border border-white/40 dark:border-white/10 rounded-2xl p-4 shadow-2xl flex items-center gap-3.5 min-w-[196px] z-10">
                            <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#F53003] to-amber-500 flex items-center justify-center text-white shadow-lg shadow-[#F53003]/30 flex-shrink-0">
                                <Mail className="w-4.5 h-4.5" />
                            </div>
                            <div>
                                <p className="text-sm font-bold text-gray-900 dark:text-white leading-tight">Notifikasi Email</p>
                                <p className="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Terkirim Otomatis</p>
                            </div>
                        </div>

                        {/* Floating card 3 */}
                        <div className="hero-card opacity-0 absolute top-1/2 right-48 bg-white/80 dark:bg-black/40 backdrop-blur-xl border border-white/40 dark:border-white/10 rounded-2xl px-5 py-4 shadow-2xl flex items-center gap-4 z-20 transform -translate-y-1/2">
                            <div className="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                                <TrendingUp className="w-6 h-6" />
                            </div>
                            <div>
                                <p className="text-sm font-medium text-gray-500 dark:text-gray-400">Kepuasan Pelanggan</p>
                                <p className="text-2xl font-black text-gradient-primary">99.8%</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Scroll indicator */}
                <div className="hero-element opacity-0 absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2">
                    <span className="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Scroll</span>
                    <div className="hero-scroll-indicator">
                        <ChevronDown className="w-5 h-5 text-gray-400 dark:text-gray-500" />
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Hero;
