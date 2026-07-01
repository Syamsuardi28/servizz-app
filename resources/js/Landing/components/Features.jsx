import React, { useEffect, useRef } from 'react';
import anime from 'animejs';
import { LogIn, Zap, CreditCard, BellRing, Smartphone, LifeBuoy, ArrowRight } from 'lucide-react';
import { cn } from '../utils';

const Features = () => {
    const sectionRef = useRef(null);

    const features = [
        {
            icon: <LogIn className="w-8 h-8" />,
            title: 'Akses Cepat (Social Login)',
            description: 'Daftar dan masuk dengan cepat menggunakan akun Google Anda tanpa ribet isi form.',
            color: 'from-blue-500 to-cyan-500',
            shadow: 'shadow-blue-500/20',
            textColor: 'text-blue-500',
            span: 'col-span-1 md:col-span-2 lg:col-span-2 row-span-2'
        },
        {
            icon: <Zap className="w-6 h-6" />,
            title: 'Lacak Proses Real-time',
            description: 'Pantau pergerakan pesanan Anda dari konfirmasi hingga selesai melalui Timeline interaktif.',
            color: 'from-[#F53003] to-orange-400',
            shadow: 'shadow-[#F53003]/20',
            textColor: 'text-[#F53003]',
            span: 'col-span-1 md:col-span-1 lg:col-span-1 row-span-1'
        },
        {
            icon: <LifeBuoy className="w-6 h-6" />,
            title: 'Pusat Bantuan Terpadu',
            description: 'Admin kami akan membalas langsung melalui dashboard.',
            color: 'from-violet-500 to-purple-500',
            shadow: 'shadow-violet-500/20',
            textColor: 'text-violet-500',
            span: 'col-span-1 md:col-span-1 lg:col-span-1 row-span-1'
        },
        {
            icon: <BellRing className="w-6 h-6" />,
            title: 'Notifikasi Email',
            description: 'Dapatkan pembaruan langsung ke email saat status berubah.',
            color: 'from-amber-400 to-yellow-400',
            shadow: 'shadow-amber-400/20',
            textColor: 'text-amber-500',
            span: 'col-span-1 md:col-span-1 lg:col-span-1 row-span-1'
        },
        {
            icon: <CreditCard className="w-8 h-8" />,
            title: 'Negosiasi & Pembayaran Aman',
            description: 'Tawar-menawar harga dengan teknisi dan lakukan pembayaran dengan aman melalui integrasi payment gateway terpercaya.',
            color: 'from-emerald-500 to-teal-500',
            shadow: 'shadow-emerald-500/20',
            textColor: 'text-emerald-500',
            span: 'col-span-1 md:col-span-2 lg:col-span-2 row-span-2'
        },
        {
            icon: <Smartphone className="w-6 h-6" />,
            title: 'Dashboard Bersih',
            description: 'Kelola profil, bukti foto, dan ulasan melalui UI yang elegan.',
            color: 'from-pink-500 to-rose-500',
            shadow: 'shadow-pink-500/20',
            textColor: 'text-pink-500',
            span: 'col-span-1 md:col-span-1 lg:col-span-1 row-span-1'
        },
    ];

    useEffect(() => {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    anime({
                        targets: '.bento-card',
                        opacity: [0, 1],
                        translateY: [40, 0],
                        scale: [0.95, 1],
                        filter: ['blur(10px)', 'blur(0px)'],
                        duration: 800,
                        easing: 'easeOutExpo',
                        delay: anime.stagger(100)
                    });
                    
                    anime({
                        targets: '.feature-header',
                        opacity: [0, 1],
                        translateY: [20, 0],
                        duration: 800,
                        easing: 'easeOutExpo'
                    });

                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, []);

    // 3D Hover Effect
    const handleMouseMove = (e, target) => {
        const rect = target.getBoundingClientRect();
        const x = e.clientX - rect.left; // x position within the element.
        const y = e.clientY - rect.top;  // y position within the element.

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = ((y - centerY) / centerY) * -5;
        const rotateY = ((x - centerX) / centerX) * 5;

        target.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        target.style.transition = 'none';
        
        // Glow effect following cursor
        const glow = target.querySelector('.bento-glow');
        if (glow) {
            glow.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(255,255,255,0.1) 0%, transparent 50%)`;
        }
    };

    const handleMouseLeave = (target) => {
        target.style.transform = `perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)`;
        target.style.transition = 'transform 0.5s cubic-bezier(0.23, 1, 0.32, 1)';
        
        const glow = target.querySelector('.bento-glow');
        if (glow) {
            glow.style.background = `transparent`;
        }
    };

    return (
        <section id="features" ref={sectionRef} className="py-28 relative overflow-hidden">
            {/* Background decoration */}
            <div className="absolute inset-0 bg-[#0a0a0a] z-[-2]" />
            <div className="absolute top-20 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[#F53003]/10 blur-[100px] rounded-full z-[-1] pointer-events-none" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Section header */}
                <div className="feature-header opacity-0 text-center max-w-3xl mx-auto mb-20">
                    <div className="mb-5">
                        <span className="section-label bg-white/5 border border-white/10 text-[#F53003]">Fitur Utama</span>
                    </div>
                    <h2 className="text-4xl md:text-5xl font-bold text-white mb-5 leading-[1.1]">
                        Sistem Pintar untuk{' '}
                        <span className="text-gradient-primary">Kebutuhan Anda</span>
                    </h2>
                    <p className="text-lg text-gray-400 leading-relaxed">
                        Servizz telah diperbarui dengan berbagai fungsionalitas sistem terkini untuk pengalaman memesan jasa yang aman, transparan, dan dapat diandalkan.
                    </p>
                </div>

                {/* Bento Grid */}
                <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-[160px]">
                    {features.map((feature, index) => (
                        <div
                            key={index}
                            className={cn(
                                "bento-card opacity-0 group relative overflow-hidden rounded-3xl bg-white/[0.03] backdrop-blur-xl border border-white/[0.08] p-6 cursor-default transition-all duration-300",
                                feature.span
                            )}
                            onMouseMove={(e) => handleMouseMove(e, e.currentTarget)}
                            onMouseLeave={(e) => handleMouseLeave(e.currentTarget)}
                        >
                            <div className="bento-glow absolute inset-0 pointer-events-none transition-all duration-300" />
                            
                            {/* Inner border glow on hover */}
                            <div className="absolute inset-0 rounded-3xl p-[1px] opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <div className={`absolute inset-0 bg-gradient-to-br ${feature.color} opacity-20`} />
                            </div>

                            <div className="relative z-10 flex flex-col h-full justify-between">
                                <div className={`w-14 h-14 rounded-2xl bg-gradient-to-br ${feature.color} flex items-center justify-center text-white mb-4 shadow-lg ${feature.shadow}`}>
                                    {feature.icon}
                                </div>
                                
                                <div>
                                    <h3 className="text-xl font-bold text-white mb-2 leading-tight">
                                        {feature.title}
                                    </h3>
                                    <p className="text-gray-400 text-sm leading-relaxed">
                                        {feature.description}
                                    </p>
                                </div>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Features;
