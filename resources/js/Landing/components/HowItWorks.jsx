import React, { useEffect, useState, useRef } from 'react';
import { LogIn, LayoutDashboard, SearchCode, Star } from 'lucide-react';

const HowItWorks = () => {
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    const steps = [
        {
            icon: <LogIn className="w-6 h-6" />,
            title: 'Daftar Praktis',
            description: 'Masuk dengan satu klik melalui Google tanpa perlu mengisi form manual panjang.',
            color: 'from-blue-500 to-cyan-500',
            shadow: 'shadow-blue-500/30',
            ring: 'ring-blue-500/20',
        },
        {
            icon: <LayoutDashboard className="w-6 h-6" />,
            title: 'Pesan & Negosiasi',
            description: 'Pilih kategori jasa, tentukan jadwal, dan lakukan tawar menawar harga dengan mitra teknisi.',
            color: 'from-[#F53003] to-orange-400',
            shadow: 'shadow-[#F53003]/30',
            ring: 'ring-[#F53003]/20',
        },
        {
            icon: <SearchCode className="w-6 h-6" />,
            title: 'Pantau Progres',
            description: 'Lacak posisi pengerjaan di Timeline dan terima notifikasi langsung di email Anda.',
            color: 'from-violet-500 to-purple-500',
            shadow: 'shadow-violet-500/30',
            ring: 'ring-violet-500/20',
        },
        {
            icon: <Star className="w-6 h-6" />,
            title: 'Bayar & Ulas',
            description: 'Bayar secara otomatis dan berikan ulasan agar komunitas teknisi tetap berkualitas.',
            color: 'from-emerald-500 to-teal-500',
            shadow: 'shadow-emerald-500/30',
            ring: 'ring-emerald-500/20',
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
        <section id="how-it-works" ref={sectionRef} className="py-32 relative overflow-hidden bg-[#050505] transition-colors duration-500">
            {/* Subtle glow backdrop */}
            <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(245,48,3,0.01)_0%,transparent_80%)]" />

            <div className="container mx-auto px-6 max-w-5xl relative z-10">
                {/* Header */}
                <div 
                    className={`text-center max-w-3xl mx-auto mb-24 transition-all duration-800 ease-out transform ${
                        isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'
                    }`}
                >
                    <div className="mb-5">
                        <span className="section-label bg-white/5 border border-white/10 text-[#F53003]">Cara Kerja</span>
                    </div>
                    <h2 className="text-4xl md:text-5xl font-bold text-white mb-5 leading-[1.1]">
                        Cara Kerja{' '}
                        <span className="text-gradient-primary">Servizz</span>
                    </h2>
                    <p className="text-lg text-gray-400 leading-relaxed">
                        Proses pemesanan jasa yang transparan, mudah dilacak, dan aman di setiap langkahnya.
                    </p>
                </div>

                <div className="relative">
                    {/* Vertical Glowing Line */}
                    <div className="absolute left-[40px] md:left-1/2 md:-translate-x-1/2 top-0 bottom-0 w-[2px] bg-white/[0.05]">
                        <div 
                            className="w-full bg-gradient-to-b from-[#F53003] via-amber-500 to-emerald-500 shadow-[0_0_15px_#F53003] transition-all duration-[2000ms] ease-in-out" 
                            style={{ height: isVisible ? '100%' : '0%' }}
                        />
                    </div>

                    <div className="space-y-16 md:space-y-24">
                        {steps.map((step, index) => {
                            const isEven = index % 2 === 0;
                            return (
                                <div key={index} className="relative flex flex-col md:flex-row items-start md:items-center justify-between group pl-24 md:pl-0">
                                    
                                    {/* Timeline Node */}
                                    <div 
                                        className={`absolute left-[40px] md:left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-black border-2 border-white z-20 transition-all duration-500 ease-out transform group-hover:scale-150 group-hover:border-[#F53003] group-hover:shadow-[0_0_20px_#F53003] ${
                                            isVisible ? 'opacity-100 scale-100' : 'opacity-0 scale-0'
                                        }`}
                                        style={{ transitionDelay: `${index * 300}ms` }}
                                    />

                                    {/* Left Content (Desktop) */}
                                    <div className={`hidden md:block w-[45%] ${isEven ? 'text-right pr-12' : 'order-last text-left pl-12'}`}>
                                        <div 
                                            className={`transition-all duration-800 ease-out transform ${
                                                isVisible 
                                                    ? 'opacity-100 translate-x-0 scale-100' 
                                                    : `opacity-0 ${isEven ? 'translate-x-8' : '-translate-x-8'} scale-95`
                                            }`}
                                            style={{ transitionDelay: `${index * 300 + 150}ms` }}
                                        >
                                            <div className="text-6xl font-black text-white/[0.03] select-none -mb-6 relative z-0">
                                                0{index + 1}
                                            </div>
                                            <div className="bg-white/[0.03] backdrop-blur-md border border-white/[0.08] rounded-2xl p-6 relative z-10 hover:bg-white/[0.06] transition-colors duration-300">
                                                <h3 className="text-xl font-bold text-white mb-2">{step.title}</h3>
                                                <p className="text-gray-400 text-sm leading-relaxed">{step.description}</p>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Mobile Content + Icon (Desktop) */}
                                    <div className={`w-full md:w-[45%] ${isEven ? 'order-last text-left md:pl-12' : 'text-left md:text-right md:pr-12'}`}>
                                        <div 
                                            className={`transition-all duration-800 ease-out transform flex flex-col ${!isEven ? 'md:items-end' : ''} ${
                                                isVisible 
                                                    ? 'opacity-100 translate-y-0 scale-100' 
                                                    : 'opacity-0 translate-y-8 scale-95'
                                            }`}
                                            style={{ transitionDelay: `${index * 300}ms` }}
                                        >
                                            <div className={`w-20 h-20 rounded-2xl bg-gradient-to-br ${step.color} flex items-center justify-center text-white mb-6 shadow-lg ${step.shadow} group-hover:scale-105 group-hover:rotate-3 transition-all duration-500`}>
                                                {step.icon}
                                            </div>
                                            
                                            {/* Mobile text content */}
                                            <div className="md:hidden">
                                                <div className="text-5xl font-black text-white/[0.05] select-none mb-2">0{index + 1}</div>
                                                <h3 className="text-xl font-bold text-white mb-2">{step.title}</h3>
                                                <p className="text-gray-400 text-sm leading-relaxed">{step.description}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            );
                        })}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default HowItWorks;
