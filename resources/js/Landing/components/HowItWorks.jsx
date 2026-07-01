import React from 'react';
import { motion } from 'framer-motion';
import { LogIn, LayoutDashboard, SearchCode, Star } from 'lucide-react';

const HowItWorks = () => {
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

    return (
        <section id="how-it-works" className="py-28 relative overflow-hidden">
            {/* Decorative background */}
            <div className="absolute top-0 inset-x-0 h-full bg-gradient-to-b from-transparent via-white/50 to-transparent dark:via-[#0a0a0a]/50 -z-10" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Header */}
                <div className="text-center max-w-3xl mx-auto mb-20">
                    <motion.div
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="mb-5"
                    >
                        <span className="section-label">Cara Kerja</span>
                    </motion.div>
                    <motion.h2
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.1 }}
                        className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-5 leading-[1.1]"
                    >
                        Cara Kerja{' '}
                        <span className="text-gradient-primary">Servizz</span>
                    </motion.h2>
                    <motion.p
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.2 }}
                        className="text-lg text-gray-500 dark:text-gray-400 leading-relaxed"
                    >
                        Proses pemesanan jasa yang transparan, mudah dilacak, dan aman di setiap langkahnya.
                    </motion.p>
                </div>

                <div className="relative">
                    {/* Animated connector line */}
                    <div className="hidden md:block absolute top-[52px] left-[10%] right-[10%] h-[2px] bg-gray-100 dark:bg-white/[0.06] rounded-full overflow-hidden">
                        <motion.div
                            initial={{ scaleX: 0, originX: 0 }}
                            whileInView={{ scaleX: 1 }}
                            viewport={{ once: true }}
                            transition={{ duration: 1.8, ease: [0.25, 0.46, 0.45, 0.94], delay: 0.3 }}
                            className="h-full bg-gradient-to-r from-blue-500 via-[#F53003] via-violet-500 to-emerald-500 rounded-full"
                        />
                    </div>

                    <div className="grid md:grid-cols-4 gap-8 md:gap-6">
                        {steps.map((step, index) => (
                            <motion.div
                                key={index}
                                initial={{ opacity: 0, y: 30 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true }}
                                transition={{ duration: 0.6, delay: 0.2 + index * 0.15 }}
                                whileHover={{ y: -6, transition: { duration: 0.25 } }}
                                className="relative flex flex-col items-center text-center group"
                            >
                                {/* Step number — background large */}
                                <div className="absolute -top-3 -right-2 text-7xl font-black text-gray-50 dark:text-white/[0.03] z-0 select-none leading-none">
                                    0{index + 1}
                                </div>

                                {/* Icon circle — layered rings */}
                                <div className={`relative z-10 mb-7 flex-shrink-0`}>
                                    {/* Outer ring */}
                                    <div className={`w-[104px] h-[104px] rounded-full ring-[6px] ${step.ring} flex items-center justify-center bg-white dark:bg-[#161615] shadow-xl border border-gray-100 dark:border-white/[0.06] group-hover:scale-105 transition-transform duration-400`}>
                                        {/* Inner gradient circle */}
                                        <div className={`w-[72px] h-[72px] rounded-full bg-gradient-to-br ${step.color} flex items-center justify-center text-white shadow-lg ${step.shadow}`}>
                                            {step.icon}
                                        </div>
                                    </div>
                                    {/* Index badge */}
                                    <div className={`absolute -top-1 -right-1 w-6 h-6 rounded-full bg-gradient-to-br ${step.color} text-white text-[11px] font-black flex items-center justify-center shadow-lg ${step.shadow}`}>
                                        {index + 1}
                                    </div>
                                </div>

                                {/* Card content */}
                                <div className="bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] card-hover-border rounded-2xl p-5 w-full relative z-10">
                                    <h3 className="text-base font-bold text-gray-900 dark:text-white mb-2">
                                        {step.title}
                                    </h3>
                                    <p className="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                                        {step.description}
                                    </p>
                                </div>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default HowItWorks;
