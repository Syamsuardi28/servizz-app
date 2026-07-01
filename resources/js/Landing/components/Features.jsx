import React from 'react';
import { motion } from 'framer-motion';
import { LogIn, Zap, CreditCard, BellRing, Smartphone, LifeBuoy, ArrowRight } from 'lucide-react';

const Features = () => {
    const features = [
        {
            icon: <LogIn className="w-6 h-6" />,
            title: 'Akses Cepat (Social Login)',
            description: 'Daftar dan masuk dengan cepat menggunakan akun Google Anda tanpa ribet isi form.',
            color: 'from-blue-500 to-cyan-500',
            shadow: 'shadow-blue-500/20',
            lightBg: 'bg-blue-50 dark:bg-blue-500/10',
            textColor: 'text-blue-600 dark:text-blue-400',
        },
        {
            icon: <Zap className="w-6 h-6" />,
            title: 'Lacak Proses Pengerjaan',
            description: 'Pantau pergerakan pesanan Anda secara real-time dari konfirmasi, teknisi berangkat, hingga selesai melalui Timeline.',
            color: 'from-[#F53003] to-orange-400',
            shadow: 'shadow-[#F53003]/20',
            lightBg: 'bg-orange-50 dark:bg-orange-500/10',
            textColor: 'text-[#F53003] dark:text-orange-400',
        },
        {
            icon: <LifeBuoy className="w-6 h-6" />,
            title: 'Pusat Bantuan Terpadu',
            description: 'Kirim pesan keluhan atau pertanyaan Anda, dan Admin kami akan membalas secara langsung melalui dashboard.',
            color: 'from-violet-500 to-purple-500',
            shadow: 'shadow-violet-500/20',
            lightBg: 'bg-violet-50 dark:bg-violet-500/10',
            textColor: 'text-violet-600 dark:text-violet-400',
        },
        {
            icon: <BellRing className="w-6 h-6" />,
            title: 'Notifikasi Email Otomatis',
            description: 'Dapatkan pembaruan langsung ke kotak masuk email Anda setiap kali status pengerjaan pesanan Anda berubah.',
            color: 'from-amber-400 to-yellow-400',
            shadow: 'shadow-amber-400/20',
            lightBg: 'bg-amber-50 dark:bg-amber-500/10',
            textColor: 'text-amber-600 dark:text-amber-400',
        },
        {
            icon: <CreditCard className="w-6 h-6" />,
            title: 'Negosiasi & Pembayaran',
            description: 'Tawar-menawar harga dengan teknisi dan lakukan pembayaran dengan aman melalui integrasi Midtrans.',
            color: 'from-emerald-500 to-teal-500',
            shadow: 'shadow-emerald-500/20',
            lightBg: 'bg-emerald-50 dark:bg-emerald-500/10',
            textColor: 'text-emerald-600 dark:text-emerald-400',
        },
        {
            icon: <Smartphone className="w-6 h-6" />,
            title: 'Dashboard yang Bersih',
            description: 'Kelola profil, unggah bukti foto pengerjaan, dan berikan rating ulasan melalui antarmuka dark mode yang elegan.',
            color: 'from-pink-500 to-rose-500',
            shadow: 'shadow-pink-500/20',
            lightBg: 'bg-pink-50 dark:bg-pink-500/10',
            textColor: 'text-pink-600 dark:text-pink-400',
        },
    ];

    return (
        <section id="features" className="py-28 relative overflow-hidden">
            {/* Background decoration */}
            <div className="absolute inset-0 bg-gradient-to-b from-gray-50/80 via-gray-50/60 to-transparent dark:from-white/[0.02] dark:via-white/[0.015] dark:to-transparent" />
            <div className="absolute top-20 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[#F53003]/4 dark:bg-[#F53003]/6 blur-[100px] rounded-full" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* Section header */}
                <div className="text-center max-w-3xl mx-auto mb-20">
                    <motion.div
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="mb-5"
                    >
                        <span className="section-label">Fitur Utama</span>
                    </motion.div>
                    <motion.h2
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.1 }}
                        className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-5 leading-[1.1]"
                    >
                        Sistem Pintar untuk{' '}
                        <span className="text-gradient-primary">Kebutuhan Anda</span>
                    </motion.h2>
                    <motion.p
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.2 }}
                        className="text-lg text-gray-500 dark:text-gray-400 leading-relaxed"
                    >
                        Servizz telah diperbarui dengan berbagai fungsionalitas sistem terkini untuk pengalaman memesan jasa yang aman, transparan, dan dapat diandalkan.
                    </motion.p>
                </div>

                {/* Features grid */}
                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {features.map((feature, index) => (
                        <motion.div
                            key={index}
                            initial={{ opacity: 0, y: 24 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.08 }}
                            whileHover={{ y: -5, transition: { duration: 0.25, ease: 'easeOut' } }}
                            className="bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] card-hover-border rounded-2xl p-7 group cursor-default relative overflow-hidden"
                        >
                            {/* Hover background glow */}
                            <div className={`absolute inset-0 bg-gradient-to-br ${feature.color} opacity-0 group-hover:opacity-[0.04] transition-opacity duration-500 rounded-2xl`} />

                            {/* Icon */}
                            <div className={`relative w-14 h-14 rounded-2xl bg-gradient-to-br ${feature.color} flex items-center justify-center text-white mb-6 shadow-lg ${feature.shadow} group-hover:scale-110 group-hover:rotate-3 transition-all duration-400`}>
                                {feature.icon}
                            </div>

                            {/* Content */}
                            <h3 className="text-lg font-bold text-gray-900 dark:text-white mb-3 leading-tight">
                                {feature.title}
                            </h3>
                            <p className="text-gray-500 dark:text-gray-400 leading-relaxed text-sm mb-5">
                                {feature.description}
                            </p>

                            {/* CTA small */}
                            <div className={`flex items-center gap-1.5 text-sm font-semibold ${feature.textColor} opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300`}>
                                Pelajari lebih lanjut
                                <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" />
                            </div>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Features;
