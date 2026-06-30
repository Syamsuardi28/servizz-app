import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Plus, Minus } from 'lucide-react';
import { cn } from '../utils';

const faqs = [
    {
        question: "Bagaimana cara mendaftar sebagai teknisi?",
        answer: "Anda dapat mendaftar dengan menekan tombol 'Daftar Sekarang', kemudian pilih peran sebagai Teknisi. Isi form pendaftaran, unggah dokumen yang diperlukan (KTP, Sertifikat), dan tunggu proses verifikasi dari tim kami."
    },
    {
        question: "Apakah ada biaya pendaftaran?",
        answer: "Tidak ada biaya pendaftaran untuk pelanggan maupun teknisi. Anda dapat membuat akun secara gratis. Kami hanya mengenakan biaya potongan sistem untuk setiap transaksi yang berhasil."
    },
    {
        question: "Bagaimana sistem pembayaran bekerja?",
        answer: "Kami menggunakan Midtrans sebagai payment gateway terpercaya. Anda bisa membayar menggunakan Bank Transfer, E-Wallet (GoPay, OVO, Dana), atau Kartu Kredit. Dana akan diteruskan ke teknisi setelah pekerjaan selesai."
    },
    {
        question: "Apa yang terjadi jika pekerjaan teknisi tidak memuaskan?",
        answer: "Kami menyediakan garansi pekerjaan. Jika Anda tidak puas dengan hasilnya, Anda dapat mengajukan komplain melalui halaman pesanan, dan tim support kami akan memediasi atau mengirimkan teknisi pengganti."
    },
    {
        question: "Apakah saya bisa membatalkan pesanan?",
        answer: "Ya, Anda bisa membatalkan pesanan selama statusnya belum dikonfirmasi oleh teknisi atau belum dalam proses pengerjaan. Jika sudah diproses, pembatalan harus dengan kesepakatan bersama teknisi."
    }
];

const FAQ = () => {
    const [openIndex, setOpenIndex] = useState(0);

    return (
        <section id="faq" className="py-24">
            <div className="container mx-auto px-6 max-w-3xl">
                <div className="text-center mb-16">
                    <h2 className="text-3xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6">
                        Pertanyaan Umum
                    </h2>
                    <p className="text-lg text-gray-600 dark:text-gray-400">
                        Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan kami.
                    </p>
                </div>

                <div className="space-y-4">
                    {faqs.map((faq, index) => (
                        <div 
                            key={index} 
                            className="bg-white dark:bg-[#161615] border border-gray-200 dark:border-white/10 rounded-2xl overflow-hidden shadow-sm"
                        >
                            <button
                                className="w-full px-6 py-5 text-left flex justify-between items-center focus:outline-none"
                                onClick={() => setOpenIndex(openIndex === index ? null : index)}
                            >
                                <span className={cn(
                                    "font-semibold text-base md:text-lg pr-4 transition-colors",
                                    openIndex === index ? "text-[#F53003]" : "text-gray-900 dark:text-white"
                                )}>
                                    {faq.question}
                                </span>
                                <div className={cn(
                                    "w-8 h-8 rounded-full flex items-center justify-center shrink-0 transition-colors",
                                    openIndex === index 
                                        ? "bg-orange-100 dark:bg-orange-500/20 text-[#F53003] dark:text-orange-400" 
                                        : "bg-gray-100 dark:bg-white/5 text-gray-500 dark:text-gray-400"
                                )}>
                                    {openIndex === index ? <Minus className="w-5 h-5" /> : <Plus className="w-5 h-5" />}
                                </div>
                            </button>
                            <AnimatePresence>
                                {openIndex === index && (
                                    <motion.div
                                        initial={{ height: 0, opacity: 0 }}
                                        animate={{ height: "auto", opacity: 1 }}
                                        exit={{ height: 0, opacity: 0 }}
                                        transition={{ duration: 0.3 }}
                                    >
                                        <div className="px-6 pb-6 text-gray-600 dark:text-gray-400 leading-relaxed border-t border-gray-100 dark:border-white/5 pt-4 mt-2">
                                            {faq.answer}
                                        </div>
                                    </motion.div>
                                )}
                            </AnimatePresence>
                        </div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default FAQ;
