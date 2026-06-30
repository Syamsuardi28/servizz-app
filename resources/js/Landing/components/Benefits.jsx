import React from 'react';
import { motion } from 'framer-motion';
import { CheckCircle2 } from 'lucide-react';

const Benefits = () => {
    const points1 = [
        "Teknisi ahli yang telah diverifikasi oleh sistem",
        "Pemilihan kategori jasa yang lengkap dan spesifik",
        "Pantau progres pesanan dari dashboard",
    ];
    const points2 = [
        "Negosiasi harga secara langsung dengan teknisi",
        "Pembayaran aman dan otomatis via Midtrans",
        "Sistem rating dan ulasan untuk transparansi kualitas",
    ];

    return (
        <section className="py-24">
            <div className="container mx-auto px-6 max-w-7xl">
                
                {/* Zigzag 1 */}
                <div className="flex flex-col lg:flex-row items-center gap-12 lg:gap-20 mb-24">
                    <motion.div 
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                        className="lg:w-1/2"
                    >
                        <div className="relative rounded-2xl overflow-hidden aspect-video bg-orange-100 dark:bg-orange-500/10">
                            {/* Abstract Illustration */}
                            <div className="absolute inset-0 flex items-center justify-center">
                                <div className="w-64 h-64 bg-[#F53003]/20 rounded-full mix-blend-multiply blur-2xl absolute"></div>
                                <div className="w-64 h-64 bg-amber-400/20 rounded-full mix-blend-multiply blur-2xl absolute translate-x-20"></div>
                                <div className="relative z-10 w-full h-full flex items-center justify-center">
                                    <div className="bg-white dark:bg-[#161615] p-6 rounded-xl shadow-xl w-3/4 transform -rotate-3 hover:rotate-0 transition-transform">
                                        <div className="h-4 w-1/3 bg-gray-200 dark:bg-white/10 rounded mb-4"></div>
                                        <div className="space-y-3">
                                            <div className="h-2 w-full bg-gray-100 dark:bg-white/5 rounded"></div>
                                            <div className="h-2 w-5/6 bg-gray-100 dark:bg-white/5 rounded"></div>
                                            <div className="h-2 w-4/6 bg-gray-100 dark:bg-white/5 rounded"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </motion.div>
                    
                    <motion.div 
                        initial={{ opacity: 0, x: 50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                        className="lg:w-1/2"
                    >
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            Solusi Cerdas untuk Segala Masalah Anda
                        </h2>
                        <p className="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                            Kami merancang Servizz untuk mempermudah Anda mencari jasa yang tepat tanpa harus membuang waktu.
                        </p>
                        <ul className="space-y-4">
                            {points1.map((point, index) => (
                                <li key={index} className="flex items-center gap-3">
                                    <CheckCircle2 className="w-6 h-6 text-green-500 shrink-0" />
                                    <span className="text-gray-700 dark:text-gray-300 font-medium">{point}</span>
                                </li>
                            ))}
                        </ul>
                    </motion.div>
                </div>

                {/* Zigzag 2 */}
                <div className="flex flex-col-reverse lg:flex-row items-center gap-12 lg:gap-20">
                    <motion.div 
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                        className="lg:w-1/2"
                    >
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                            Manajemen Transaksi Lebih Transparan
                        </h2>
                        <p className="text-lg text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                            Nikmati kemudahan dalam mengelola pembayaran dan komunikasi dua arah dengan teknisi pilihan Anda.
                        </p>
                        <ul className="space-y-4">
                            {points2.map((point, index) => (
                                <li key={index} className="flex items-center gap-3">
                                    <CheckCircle2 className="w-6 h-6 text-green-500 shrink-0" />
                                    <span className="text-gray-700 dark:text-gray-300 font-medium">{point}</span>
                                </li>
                            ))}
                        </ul>
                    </motion.div>

                    <motion.div 
                        initial={{ opacity: 0, x: 50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 0.6 }}
                        className="lg:w-1/2"
                    >
                        <div className="relative rounded-2xl overflow-hidden aspect-video bg-green-50 dark:bg-green-500/10">
                            {/* Abstract Illustration */}
                            <div className="absolute inset-0 flex items-center justify-center">
                                <div className="w-64 h-64 bg-green-400/20 rounded-full mix-blend-multiply blur-2xl absolute"></div>
                                <div className="relative z-10 w-full h-full flex items-center justify-center">
                                    <div className="bg-white dark:bg-[#161615] p-6 rounded-xl shadow-xl w-3/4 transform rotate-3 hover:rotate-0 transition-transform">
                                        <div className="flex justify-between items-center mb-6">
                                            <div className="w-12 h-12 rounded-full bg-green-100 dark:bg-green-500/20"></div>
                                            <div className="h-6 w-20 bg-gray-100 dark:bg-white/5 rounded-full"></div>
                                        </div>
                                        <div className="h-3 w-full bg-gray-100 dark:bg-white/5 rounded mb-2"></div>
                                        <div className="h-3 w-2/3 bg-gray-100 dark:bg-white/5 rounded"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </motion.div>
                </div>

            </div>
        </section>
    );
};

export default Benefits;
