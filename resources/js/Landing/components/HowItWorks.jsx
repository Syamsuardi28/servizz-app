import React from 'react';
import { motion } from 'framer-motion';
import { LogIn, LayoutDashboard, SearchCode, Star } from 'lucide-react';

const HowItWorks = () => {
    const steps = [
        {
            icon: <LogIn className="w-6 h-6" />,
            title: "Daftar Praktis",
            description: "Masuk dengan satu klik melalui Google tanpa perlu mengisi form manual panjang."
        },
        {
            icon: <LayoutDashboard className="w-6 h-6" />,
            title: "Pesan & Negosiasi",
            description: "Pilih kategori jasa, tentukan jadwal, dan lakukan tawar menawar harga dengan mitra teknisi."
        },
        {
            icon: <SearchCode className="w-6 h-6" />,
            title: "Pantau Progres",
            description: "Lacak posisi pengerjaan di Timeline dan terima notifikasi langsung di email Anda."
        },
        {
            icon: <Star className="w-6 h-6" />,
            title: "Bayar & Ulas",
            description: "Bayar secara otomatis dan berikan ulasan agar komunitas teknisi tetap berkualitas."
        }
    ];

    return (
        <section id="how-it-works" className="py-24 relative overflow-hidden">
            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                <div className="text-center max-w-3xl mx-auto mb-16">
                    <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        Cara Kerja Servizz
                    </h2>
                    <p className="text-lg text-gray-600 dark:text-gray-400">
                        Proses pemesanan jasa yang transparan, mudah dilacak, dan aman di setiap langkahnya.
                    </p>
                </div>

                <div className="relative">
                    {/* Connection line for desktop */}
                    <div className="hidden md:block absolute top-1/2 left-0 w-full h-1 bg-gray-100 dark:bg-[#3E3E3A] -translate-y-1/2 rounded-full overflow-hidden">
                        <motion.div 
                            initial={{ width: 0 }}
                            whileInView={{ width: "100%" }}
                            viewport={{ once: true }}
                            transition={{ duration: 1.5, ease: "easeOut" }}
                            className="h-full bg-gradient-to-r from-[#F53003] to-amber-500"
                        />
                    </div>

                    <div className="grid md:grid-cols-4 gap-12 md:gap-8">
                        {steps.map((step, index) => (
                            <motion.div
                                key={index}
                                initial={{ opacity: 0, y: 30 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true }}
                                transition={{ duration: 0.6, delay: index * 0.2 }}
                                className="relative flex flex-col items-center text-center group"
                            >
                                {/* Step number */}
                                <div className="absolute -top-4 -right-2 text-6xl font-bold text-gray-50 dark:text-white/5 z-0 group-hover:scale-110 transition-transform">
                                    0{index + 1}
                                </div>
                                
                                <div className="w-20 h-20 bg-white dark:bg-[#161615] rounded-2xl shadow-xl border border-gray-100 dark:border-[#3E3E3A] flex items-center justify-center text-[#F53003] dark:text-orange-400 mb-6 relative z-10 group-hover:-translate-y-2 group-hover:bg-[#F53003] group-hover:text-white transition-all duration-300">
                                    {step.icon}
                                </div>
                                
                                <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-3 relative z-10">
                                    {step.title}
                                </h3>
                                <p className="text-gray-600 dark:text-gray-400 leading-relaxed relative z-10">
                                    {step.description}
                                </p>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </div>
        </section>
    );
};

export default HowItWorks;
