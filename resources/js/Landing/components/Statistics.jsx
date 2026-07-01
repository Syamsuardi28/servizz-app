import React, { useEffect, useState } from 'react';
import { motion, useInView } from 'framer-motion';
import { Users, Briefcase, Star, HeadphonesIcon } from 'lucide-react';

const Counter = ({ value, suffix = '', prefix = '' }) => {
    const [count, setCount] = useState(0);
    const ref = React.useRef(null);
    const isInView = useInView(ref, { once: true, margin: '-80px' });

    useEffect(() => {
        if (!isInView) return;
        const end = parseInt(value.replace(/,/g, ''));
        if (end === 0) return;

        const duration = 2000;
        const steps = 60;
        const stepTime = duration / steps;
        let current = 0;

        const timer = setInterval(() => {
            // Ease-out: faster at start, slower at end
            const progress = current / steps;
            const eased = 1 - Math.pow(1 - progress, 3);
            const displayVal = Math.round(eased * end);
            setCount(displayVal);
            current++;
            if (current > steps) {
                setCount(end);
                clearInterval(timer);
            }
        }, stepTime);

        return () => clearInterval(timer);
    }, [isInView, value]);

    return (
        <span ref={ref}>
            {prefix}
            {count.toLocaleString('id-ID')}
            {suffix}
        </span>
    );
};

const Statistics = () => {
    const stats = [
        {
            id: 1,
            label: 'Pengguna Aktif',
            value: '10000',
            suffix: '+',
            icon: <Users className="w-6 h-6" />,
            color: 'from-blue-500 to-blue-600',
            shadow: 'shadow-blue-500/25',
            bgLight: 'bg-blue-50 dark:bg-blue-500/10',
            textColor: 'text-blue-600 dark:text-blue-400',
        },
        {
            id: 2,
            label: 'Mitra Perusahaan',
            value: '250',
            suffix: '+',
            icon: <Briefcase className="w-6 h-6" />,
            color: 'from-violet-500 to-purple-600',
            shadow: 'shadow-violet-500/25',
            bgLight: 'bg-violet-50 dark:bg-violet-500/10',
            textColor: 'text-violet-600 dark:text-violet-400',
        },
        {
            id: 3,
            label: 'Kepuasan Pelanggan',
            value: '98',
            suffix: '%',
            icon: <Star className="w-6 h-6" />,
            color: 'from-amber-400 to-orange-500',
            shadow: 'shadow-amber-400/25',
            bgLight: 'bg-amber-50 dark:bg-amber-500/10',
            textColor: 'text-amber-600 dark:text-amber-400',
        },
        {
            id: 4,
            label: 'Dukungan Admin',
            value: '24',
            suffix: '/7',
            icon: <HeadphonesIcon className="w-6 h-6" />,
            color: 'from-emerald-500 to-teal-600',
            shadow: 'shadow-emerald-500/25',
            bgLight: 'bg-emerald-50 dark:bg-emerald-500/10',
            textColor: 'text-emerald-600 dark:text-emerald-400',
        },
    ];

    return (
        <section className="py-24 relative overflow-hidden">
            {/* Subtle section background */}
            <div className="absolute inset-0 bg-gradient-to-b from-transparent via-gray-50/50 to-transparent dark:via-white/[0.02]" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Section header */}
                <motion.div
                    initial={{ opacity: 0, y: 16 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    className="text-center mb-14"
                >
                    <span className="section-label mb-4 inline-block">Angka Bicara</span>
                    <h2 className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mt-4">
                        Dipercaya Ribuan Pengguna
                    </h2>
                </motion.div>

                <div className="grid grid-cols-2 md:grid-cols-4 gap-5 md:gap-6">
                    {stats.map((stat, index) => (
                        <motion.div
                            key={stat.id}
                            initial={{ opacity: 0, y: 24, scale: 0.95 }}
                            whileInView={{ opacity: 1, y: 0, scale: 1 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.1, ease: [0.25, 0.46, 0.45, 0.94] }}
                            whileHover={{ y: -6, transition: { duration: 0.3, ease: 'easeOut' } }}
                            className="bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] card-hover-border rounded-2xl p-7 flex flex-col items-center justify-center text-center group cursor-default"
                        >
                            {/* Icon */}
                            <div className={`relative w-14 h-14 mb-5 rounded-2xl bg-gradient-to-br ${stat.color} flex items-center justify-center text-white shadow-lg ${stat.shadow} group-hover:scale-110 transition-transform duration-300`}>
                                {stat.icon}
                                {/* Glow */}
                                <div className={`absolute inset-0 rounded-2xl bg-gradient-to-br ${stat.color} opacity-0 group-hover:opacity-40 blur-xl transition-opacity duration-300`} />
                            </div>

                            {/* Number */}
                            <div className="text-4xl md:text-5xl font-black text-gradient-primary mb-2 tabular-nums">
                                <Counter value={stat.value} suffix={stat.suffix} prefix={stat.prefix} />
                            </div>

                            {/* Label */}
                            <div className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {stat.label}
                            </div>

                            {/* Bottom accent line */}
                            <div className={`mt-4 h-0.5 w-8 bg-gradient-to-r ${stat.color} rounded-full opacity-0 group-hover:opacity-100 group-hover:w-16 transition-all duration-400`} />
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Statistics;
