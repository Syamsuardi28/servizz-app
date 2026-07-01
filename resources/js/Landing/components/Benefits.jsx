import React from 'react';
import { motion } from 'framer-motion';
import { CheckCircle2, ArrowRight, Shield, CreditCard, Star } from 'lucide-react';

const BenefitIllustration1 = () => (
    <div className="relative rounded-2xl overflow-hidden bg-gradient-to-br from-orange-50 to-amber-50 dark:from-[#1a0800]/80 dark:to-[#1a0500]/60 border border-orange-100/80 dark:border-orange-500/10 aspect-[4/3] flex items-center justify-center p-8">
        {/* Background glow */}
        <div className="absolute inset-0">
            <div className="absolute top-0 left-0 w-48 h-48 bg-[#F53003]/15 rounded-full blur-3xl" />
            <div className="absolute bottom-0 right-0 w-40 h-40 bg-amber-400/15 rounded-full blur-3xl" />
        </div>
        {/* Card UI */}
        <motion.div
            initial={{ rotate: -4 }}
            whileHover={{ rotate: 0 }}
            transition={{ duration: 0.4 }}
            className="relative z-10 w-full max-w-[280px] bg-white dark:bg-[#1c1c1b] rounded-2xl shadow-2xl shadow-black/10 dark:shadow-black/40 border border-gray-100 dark:border-white/[0.06] p-5"
        >
            {/* Card header */}
            <div className="flex items-center justify-between mb-5">
                <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-[#F53003] to-amber-400 flex items-center justify-center text-white shadow-lg shadow-[#F53003]/30">
                        <Shield className="w-5 h-5" />
                    </div>
                    <div className="space-y-1">
                        <div className="h-2.5 w-24 bg-gray-700 dark:bg-white/20 rounded" />
                        <div className="h-1.5 w-16 bg-gray-200 dark:bg-white/10 rounded" />
                    </div>
                </div>
                <span className="text-[10px] font-bold px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400">
                    Terverifikasi
                </span>
            </div>
            {/* Progress steps */}
            <div className="space-y-3">
                {['Diajukan', 'Dikonfirmasi', 'Proses', 'Selesai'].map((s, i) => (
                    <div key={i} className="flex items-center gap-3">
                        <div className={`w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 ${
                            i <= 2
                                ? 'bg-gradient-to-br from-[#F53003] to-amber-400 shadow-sm shadow-[#F53003]/30'
                                : 'bg-gray-100 dark:bg-white/8'
                        }`}>
                            {i <= 2 && <CheckCircle2 className="w-3 h-3 text-white" />}
                        </div>
                        <div className={`h-2 rounded flex-1 ${
                            i <= 2
                                ? 'bg-gradient-to-r from-[#F53003]/20 to-amber-400/10 dark:from-[#F53003]/25 dark:to-amber-400/15'
                                : 'bg-gray-100 dark:bg-white/5'
                        }`} />
                        <span className={`text-[10px] font-semibold flex-shrink-0 ${
                            i <= 2 ? 'text-[#F53003] dark:text-orange-400' : 'text-gray-300 dark:text-white/20'
                        }`}>{s}</span>
                    </div>
                ))}
            </div>
        </motion.div>
    </div>
);

const BenefitIllustration2 = () => (
    <div className="relative rounded-2xl overflow-hidden bg-gradient-to-br from-emerald-50 to-teal-50/50 dark:from-[#001a10]/80 dark:to-[#001510]/60 border border-emerald-100/80 dark:border-emerald-500/10 aspect-[4/3] flex items-center justify-center p-8">
        {/* Background glow */}
        <div className="absolute inset-0">
            <div className="absolute top-0 right-0 w-48 h-48 bg-emerald-400/15 rounded-full blur-3xl" />
            <div className="absolute bottom-0 left-0 w-40 h-40 bg-teal-400/10 rounded-full blur-3xl" />
        </div>
        {/* Payment card UI */}
        <motion.div
            initial={{ rotate: 3 }}
            whileHover={{ rotate: 0 }}
            transition={{ duration: 0.4 }}
            className="relative z-10 w-full max-w-[280px] bg-white dark:bg-[#1c1c1b] rounded-2xl shadow-2xl shadow-black/10 dark:shadow-black/40 border border-gray-100 dark:border-white/[0.06] p-5"
        >
            <div className="flex justify-between items-start mb-6">
                <div className="flex items-center gap-2.5">
                    <div className="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                        <CreditCard className="w-5 h-5" />
                    </div>
                    <div className="space-y-1">
                        <div className="h-2.5 w-20 bg-gray-700 dark:bg-white/20 rounded" />
                        <div className="h-1.5 w-14 bg-gray-200 dark:bg-white/10 rounded" />
                    </div>
                </div>
                <div className="flex gap-1">
                    {[...Array(5)].map((_, i) => (
                        <Star key={i} className="w-3 h-3 fill-amber-400 text-amber-400" />
                    ))}
                </div>
            </div>
            {/* Amount */}
            <div className="mb-5 p-4 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-500/10 dark:to-teal-500/8 border border-emerald-100 dark:border-emerald-500/15">
                <p className="text-xs text-gray-400 dark:text-white/30 mb-1">Total Pembayaran</p>
                <p className="text-2xl font-black text-emerald-600 dark:text-emerald-400">Rp 350.000</p>
            </div>
            {/* Payment methods */}
            <div className="flex gap-2">
                {['GoPay', 'OVO', 'Transfer'].map((m, i) => (
                    <div key={i} className={`flex-1 py-1.5 rounded-lg text-[9px] font-bold text-center ${
                        i === 0 ? 'bg-emerald-500 text-white' : 'bg-gray-100 dark:bg-white/5 text-gray-400 dark:text-white/20'
                    }`}>{m}</div>
                ))}
            </div>
        </motion.div>
    </div>
);

const Benefits = () => {
    const points1 = [
        'Teknisi ahli yang telah diverifikasi oleh sistem',
        'Pemilihan kategori jasa yang lengkap dan spesifik',
        'Pantau progres pesanan dari dashboard',
    ];
    const points2 = [
        'Negosiasi harga secara langsung dengan teknisi',
        'Pembayaran aman dan otomatis via Midtrans',
        'Sistem rating dan ulasan untuk transparansi kualitas',
    ];

    const listVariants = {
        hidden: {},
        visible: { transition: { staggerChildren: 0.12 } }
    };
    const itemVariants = {
        hidden: { opacity: 0, x: -16 },
        visible: { opacity: 1, x: 0, transition: { duration: 0.4, ease: 'easeOut' } }
    };

    return (
        <section className="py-28 relative overflow-hidden">
            <div className="container mx-auto px-6 max-w-7xl">

                {/* ── Block 1 ── */}
                <div className="flex flex-col lg:flex-row items-center gap-14 lg:gap-24 mb-28">
                    <motion.div
                        initial={{ opacity: 0, x: -40 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.7 }}
                        className="lg:w-1/2"
                    >
                        <BenefitIllustration1 />
                    </motion.div>

                    <motion.div
                        initial={{ opacity: 0, x: 40 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.7, delay: 0.1 }}
                        className="lg:w-1/2"
                    >
                        <span className="section-label mb-5 inline-block">Untuk Pelanggan</span>
                        <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-[1.1]">
                            Solusi Cerdas untuk Segala{' '}
                            <span className="text-gradient-primary">Masalah Anda</span>
                        </h2>
                        <p className="text-lg text-gray-500 dark:text-gray-400 mb-9 leading-relaxed">
                            Kami merancang Servizz untuk mempermudah Anda mencari jasa yang tepat tanpa harus membuang waktu.
                        </p>
                        <motion.ul
                            variants={listVariants}
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            className="space-y-4 mb-8"
                        >
                            {points1.map((point, index) => (
                                <motion.li key={index} variants={itemVariants} className="flex items-start gap-3.5">
                                    <div className="w-5 h-5 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center flex-shrink-0 mt-0.5 shadow-md shadow-emerald-400/30">
                                        <CheckCircle2 className="w-3 h-3 text-white" />
                                    </div>
                                    <span className="text-gray-700 dark:text-gray-300 leading-relaxed">{point}</span>
                                </motion.li>
                            ))}
                        </motion.ul>
                        <a
                            href="#features"
                            className="inline-flex items-center gap-2 text-sm font-semibold text-[#F53003] dark:text-orange-400 hover:gap-3 transition-all duration-200 group"
                        >
                            Lihat semua fitur
                            <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" />
                        </a>
                    </motion.div>
                </div>

                {/* ── Block 2 ── */}
                <div className="flex flex-col-reverse lg:flex-row items-center gap-14 lg:gap-24">
                    <motion.div
                        initial={{ opacity: 0, x: -40 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.7 }}
                        className="lg:w-1/2"
                    >
                        <span className="section-label mb-5 inline-block">Untuk Teknisi</span>
                        <h2 className="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-[1.1]">
                            Manajemen Transaksi{' '}
                            <span className="text-gradient-primary">Lebih Transparan</span>
                        </h2>
                        <p className="text-lg text-gray-500 dark:text-gray-400 mb-9 leading-relaxed">
                            Nikmati kemudahan dalam mengelola pembayaran dan komunikasi dua arah dengan teknisi pilihan Anda.
                        </p>
                        <motion.ul
                            variants={listVariants}
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            className="space-y-4 mb-8"
                        >
                            {points2.map((point, index) => (
                                <motion.li key={index} variants={itemVariants} className="flex items-start gap-3.5">
                                    <div className="w-5 h-5 rounded-full bg-gradient-to-br from-blue-400 to-violet-500 flex items-center justify-center flex-shrink-0 mt-0.5 shadow-md shadow-blue-400/30">
                                        <CheckCircle2 className="w-3 h-3 text-white" />
                                    </div>
                                    <span className="text-gray-700 dark:text-gray-300 leading-relaxed">{point}</span>
                                </motion.li>
                            ))}
                        </motion.ul>
                        <a
                            href="#how-it-works"
                            className="inline-flex items-center gap-2 text-sm font-semibold text-[#F53003] dark:text-orange-400 hover:gap-3 transition-all duration-200 group"
                        >
                            Cara kerjanya
                            <ArrowRight className="w-4 h-4 group-hover:translate-x-1 transition-transform duration-200" />
                        </a>
                    </motion.div>

                    <motion.div
                        initial={{ opacity: 0, x: 40 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.7, delay: 0.1 }}
                        className="lg:w-1/2"
                    >
                        <BenefitIllustration2 />
                    </motion.div>
                </div>

            </div>
        </section>
    );
};

export default Benefits;
