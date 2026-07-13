import React, { useEffect, useState, useRef } from 'react';
import { Users, Briefcase, Star, HeadphonesIcon } from 'lucide-react';

const StatCounter = ({ endVal, suffix, isVisible }) => {
    const [count, setCount] = useState(0);

    useEffect(() => {
        if (!isVisible) return;
        
        let startTimestamp = null;
        const duration = 1500; // 1.5 seconds

        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            setCount(Math.floor(progress * endVal));
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };

        window.requestAnimationFrame(step);
    }, [isVisible, endVal]);

    return (
        <span>
            {count.toLocaleString('id-ID')}
            {suffix}
        </span>
    );
};

const Statistics = () => {
    const sectionRef = useRef(null);
    const [isVisible, setIsVisible] = useState(false);

    const stats = [
        {
            id: 1,
            label: 'Pengguna Aktif',
            value: 10000,
            suffix: '+',
            icon: <Users className="w-6 h-6" />,
            color: 'from-blue-500 to-blue-600',
            shadow: 'shadow-blue-500/25',
        },
        {
            id: 2,
            label: 'Mitra Perusahaan',
            value: 250,
            suffix: '+',
            icon: <Briefcase className="w-6 h-6" />,
            color: 'from-violet-500 to-purple-600',
            shadow: 'shadow-violet-500/25',
        },
        {
            id: 3,
            label: 'Kepuasan Pelanggan',
            value: 98,
            suffix: '%',
            icon: <Star className="w-6 h-6" />,
            color: 'from-amber-400 to-orange-500',
            shadow: 'shadow-amber-400/25',
        },
        {
            id: 4,
            label: 'Dukungan Admin',
            value: 24,
            suffix: '/7',
            icon: <HeadphonesIcon className="w-6 h-6" />,
            color: 'from-emerald-500 to-teal-600',
            shadow: 'shadow-emerald-500/25',
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
        <section ref={sectionRef} className="py-24 relative overflow-hidden bg-[#050505] transition-colors duration-500">
            {/* Subtle section background */}
            <div className="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(255,255,255,0.02)_0%,transparent_70%)]" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Section header */}
                <div 
                    className={`text-center mb-16 transition-all duration-800 ease-out transform ${
                        isVisible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'
                    }`}
                >
                    <span className="section-label mb-4 inline-block bg-white/5 border border-white/10 text-white">Angka Bicara</span>
                    <h2 className="text-3xl md:text-4xl font-bold text-white mt-4">
                        Dipercaya Ribuan Pengguna
                    </h2>
                </div>

                <div className="grid grid-cols-2 md:grid-cols-4 gap-5 md:gap-6">
                    {stats.map((stat, index) => (
                        <div
                            key={stat.id}
                            className={`bg-white/[0.03] backdrop-blur-xl border border-white/[0.08] rounded-3xl p-8 flex flex-col items-center justify-center text-center group cursor-default relative overflow-hidden transition-all duration-700 ease-out transform hover:-translate-y-2 hover:bg-white/[0.05] hover:border-white/[0.12] hover:shadow-[0_10px_40px_rgba(0,0,0,0.5)] ${
                                isVisible 
                                    ? 'opacity-100 translate-y-0 scale-100' 
                                    : 'opacity-0 translate-y-8 scale-95'
                            }`}
                            style={{ transitionDelay: `${index * 150}ms` }}
                        >
                            {/* Glow behind icon */}
                            <div className={`absolute top-8 w-24 h-24 rounded-full bg-gradient-to-br ${stat.color} opacity-0 group-hover:opacity-25 blur-2xl transition-opacity duration-500`} />

                            {/* Icon */}
                            <div className={`relative w-14 h-14 mb-6 rounded-2xl bg-gradient-to-br ${stat.color} flex items-center justify-center text-white shadow-lg ${stat.shadow} group-hover:scale-110 transition-transform duration-300 z-10`}>
                                {stat.icon}
                            </div>

                            {/* Number */}
                            <div className="text-4xl md:text-5xl font-black text-white mb-2 tabular-nums z-10">
                                <StatCounter endVal={stat.value} suffix={stat.suffix} isVisible={isVisible} />
                            </div>

                            {/* Label */}
                            <div className="text-sm font-medium text-gray-400 z-10">
                                {stat.label}
                            </div>

                            {/* Bottom accent line */}
                            <div className={`mt-5 h-[2px] w-8 bg-gradient-to-r ${stat.color} rounded-full opacity-0 group-hover:opacity-100 group-hover:w-16 transition-all duration-400 z-10`} />
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Statistics;
