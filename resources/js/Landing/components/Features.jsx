import React, { useEffect, useState, useRef } from 'react';
import { LogIn, Zap, CreditCard, BellRing, Smartphone, LifeBuoy } from 'lucide-react';
import { cn } from '../utils';

const Features = () => {
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

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
                    setIsVisible(true);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });

        if (sectionRef.current) {
            observer.observe(sectionRef.current);
        }

        return () => observer.disconnect();
    }, []);

    return (
        <section id="features" ref={sectionRef} className="py-28 relative overflow-hidden bg-white dark:bg-[#0a0a0a] transition-colors duration-500">
            {/* Background decoration */}
            <div className="absolute top-20 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[#F53003]/5 dark:bg-[#F53003]/8 blur-[100px] rounded-full pointer-events-none" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Section header */}
                <div 
                    className={`text-center max-w-3xl mx-auto mb-20 transition-all duration-800 ease-out transform ${
                        isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'
                    }`}
                >
                    <div className="mb-5">
                        <span className="section-label bg-white/5 border border-white/10 text-[#F53003]">Fitur Utama</span>
                    </div>
                    <h2 className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-5 leading-[1.1]">
                        Sistem Pintar untuk{' '}
                        <span className="text-gradient-primary">Kebutuhan Anda</span>
                    </h2>
                    <p className="text-lg text-gray-500 dark:text-gray-400 leading-relaxed">
                        Servizz telah diperbarui dengan berbagai fungsionalitas sistem terkini untuk pengalaman memesan jasa yang aman, transparan, dan dapat diandalkan.
                    </p>
                </div>

                {/* Bento Grid */}
                <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-[160px]">
                    {features.map((feature, index) => (
                        <div
                            key={index}
                            className={cn(
                                "group relative overflow-hidden rounded-3xl bg-gray-50 dark:bg-white/[0.02] border border-gray-200/50 dark:border-white/[0.08] p-6 cursor-default transition-all duration-700 ease-out transform hover:-translate-y-1.5 hover:bg-gray-100/50 dark:hover:bg-white/[0.04] hover:border-[#F53003]/30 dark:hover:border-[#F53003]/30 hover:shadow-[0_20px_50px_-12px_rgba(245,48,3,0.12)]",
                                feature.span,
                                isVisible 
                                    ? 'opacity-100 translate-y-0 scale-100' 
                                    : 'opacity-0 translate-y-8 scale-95'
                            )}
                            style={{ transitionDelay: `${index * 100}ms` }}
                        >
                            {/* Hover light glow effect */}
                            <div className="absolute -inset-24 bg-[radial-gradient(circle_at_center,rgba(245,48,3,0.06)_0%,transparent_50%)] opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" />

                            <div className="relative z-10 flex flex-col h-full justify-between">
                                <div className={`w-14 h-14 rounded-2xl bg-gradient-to-br ${feature.color} flex items-center justify-center text-white mb-4 shadow-lg ${feature.shadow} group-hover:scale-105 transition-transform duration-300`}>
                                    {feature.icon}
                                </div>
                                
                                <div>
                                    <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2 leading-tight">
                                        {feature.title}
                                    </h3>
                                    <p className="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
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
