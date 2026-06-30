import React, { useEffect, useState } from 'react';
import { motion, useInView } from 'framer-motion';
import { Users, Briefcase, Star, HeadphonesIcon } from 'lucide-react';

const Counter = ({ value, suffix = "", prefix = "" }) => {
    const [count, setCount] = useState(0);
    const ref = React.useRef(null);
    const isInView = useInView(ref, { once: true, margin: "-100px" });

    useEffect(() => {
        if (isInView) {
            let start = 0;
            const end = parseInt(value.replace(/,/g, ''));
            if (start === end) return;

            let totalMilSecDur = parseInt(2000);
            let incrementTime = (totalMilSecDur / end) * 2;
            if (incrementTime < 10) incrementTime = 10;

            let timer = setInterval(() => {
                start += Math.ceil(end / 50);
                if (start >= end) {
                    clearInterval(timer);
                    setCount(end);
                } else {
                    setCount(start);
                }
            }, incrementTime);
            return () => clearInterval(timer);
        }
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
        { id: 1, label: 'Pengguna', value: '10000', suffix: '+', icon: <Users className="w-6 h-6" /> },
        { id: 2, label: 'Perusahaan', value: '250', suffix: '+', icon: <Briefcase className="w-6 h-6" /> },
        { id: 3, label: 'Kepuasan', value: '98', suffix: '%', icon: <Star className="w-6 h-6" /> },
        { id: 4, label: 'Support', value: '24', suffix: '/7', icon: <HeadphonesIcon className="w-6 h-6" /> },
    ];

    return (
        <section className="py-20 relative">
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="grid grid-cols-2 md:grid-cols-4 gap-8">
                    {stats.map((stat, index) => (
                        <motion.div
                            key={stat.id}
                            initial={{ opacity: 0, y: 20 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.1 }}
                            className="flex flex-col items-center justify-center p-6 rounded-2xl bg-white dark:bg-[#161615] shadow-xl shadow-gray-200/50 dark:shadow-black/20 border border-gray-100 dark:border-white/5 hover:-translate-y-2 transition-transform duration-300"
                        >
                            <div className="w-12 h-12 mb-4 rounded-full bg-orange-100 dark:bg-orange-500/20 text-[#F53003] dark:text-orange-400 flex items-center justify-center">
                                {stat.icon}
                            </div>
                            <div className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-2">
                                <Counter value={stat.value} suffix={stat.suffix} />
                            </div>
                            <div className="text-sm font-medium text-gray-500 dark:text-gray-400">
                                {stat.label}
                            </div>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Statistics;
