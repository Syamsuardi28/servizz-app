import React from 'react';
import { motion } from 'framer-motion';
import { LogIn, Zap, CreditCard, BellRing, Smartphone, LifeBuoy } from 'lucide-react';

const Features = () => {
    const features = [
        {
            icon: <LogIn className="w-6 h-6" />,
            title: "Akses Cepat (Social Login)",
            description: "Daftar dan masuk dengan cepat menggunakan akun Google Anda tanpa ribet isi form."
        },
        {
            icon: <Zap className="w-6 h-6" />,
            title: "Lacak Proses Pengerjaan",
            description: "Pantau pergerakan pesanan Anda secara real-time dari konfirmasi, teknisi berangkat, hingga selesai melalui Timeline."
        },
        {
            icon: <LifeBuoy className="w-6 h-6" />,
            title: "Pusat Bantuan Terpadu",
            description: "Kirim pesan keluhan atau pertanyaan Anda, dan Admin kami akan membalas secara langsung melalui dashboard."
        },
        {
            icon: <BellRing className="w-6 h-6" />,
            title: "Notifikasi Email Otomatis",
            description: "Dapatkan pembaruan langsung ke kotak masuk email Anda setiap kali status pengerjaan pesanan Anda berubah."
        },
        {
            icon: <CreditCard className="w-6 h-6" />,
            title: "Negosiasi & Pembayaran",
            description: "Tawar-menawar harga dengan teknisi dan lakukan pembayaran dengan aman melalui integrasi Midtrans."
        },
        {
            icon: <Smartphone className="w-6 h-6" />,
            title: "Dashboard yang Bersih",
            description: "Kelola profil, unggah bukti foto pengerjaan, dan berikan rating ulasan melalui antarmuka dark mode yang elegan."
        }
    ];

    return (
        <section id="features" className="py-24 bg-gray-50 dark:bg-white/[0.02]">
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <motion.span 
                        initial={{ opacity: 0, y: 10 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="text-[#F53003] dark:text-orange-400 font-semibold tracking-wider uppercase text-sm mb-4 block"
                    >
                        Fitur Utama
                    </motion.span>
                    <motion.h2 
                        initial={{ opacity: 0, y: 10 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.1 }}
                        className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6"
                    >
                        Sistem Pintar untuk Kebutuhan Anda
                    </motion.h2>
                    <motion.p 
                        initial={{ opacity: 0, y: 10 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.2 }}
                        className="text-lg text-gray-600 dark:text-gray-400"
                    >
                        Servizz telah diperbarui dengan berbagai fungsionalitas sistem terkini untuk pengalaman memesan jasa yang aman, transparan, dan dapat diandalkan.
                    </motion.p>
                </div>

                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {features.map((feature, index) => (
                        <motion.div
                            key={index}
                            initial={{ opacity: 0, y: 20 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.5, delay: index * 0.1 }}
                            className="bg-white dark:bg-[#161615] p-8 rounded-2xl shadow-lg shadow-gray-200/50 dark:shadow-black/20 border border-gray-100 dark:border-[#3E3E3A] group hover:-translate-y-2 transition-all duration-300"
                        >
                            <div className="w-14 h-14 rounded-xl bg-orange-50 dark:bg-[#20201f] text-[#F53003] dark:text-orange-400 flex items-center justify-center mb-6 group-hover:bg-[#F53003] group-hover:text-white transition-colors duration-300">
                                {feature.icon}
                            </div>
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3">
                                {feature.title}
                            </h3>
                            <p className="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {feature.description}
                            </p>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default Features;
