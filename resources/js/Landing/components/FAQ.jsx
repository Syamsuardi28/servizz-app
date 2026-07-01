import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Plus } from 'lucide-react';
import { cn } from '../utils';

const faqs = [
    {
        question: 'Bagaimana cara mendaftar sebagai teknisi?',
        answer: 'Anda dapat mendaftar dengan menekan tombol \'Daftar Sekarang\', kemudian pilih peran sebagai Teknisi. Isi form pendaftaran, unggah dokumen yang diperlukan (KTP, Sertifikat), dan tunggu proses verifikasi dari tim kami.',
    },
    {
        question: 'Apakah ada biaya pendaftaran?',
        answer: 'Tidak ada biaya pendaftaran untuk pelanggan maupun teknisi. Anda dapat membuat akun secara gratis. Kami hanya mengenakan biaya potongan sistem untuk setiap transaksi yang berhasil.',
    },
    {
        question: 'Bagaimana sistem pembayaran bekerja?',
        answer: 'Kami menggunakan Midtrans sebagai payment gateway terpercaya. Anda bisa membayar menggunakan Bank Transfer, E-Wallet (GoPay, OVO, Dana), atau Kartu Kredit. Dana akan diteruskan ke teknisi setelah pekerjaan selesai.',
    },
    {
        question: 'Apa yang terjadi jika pekerjaan teknisi tidak memuaskan?',
        answer: 'Kami menyediakan garansi pekerjaan. Jika Anda tidak puas dengan hasilnya, Anda dapat mengajukan komplain melalui halaman pesanan, dan tim support kami akan memediasi atau mengirimkan teknisi pengganti.',
    },
    {
        question: 'Apakah saya bisa membatalkan pesanan?',
        answer: 'Ya, Anda bisa membatalkan pesanan selama statusnya belum dikonfirmasi oleh teknisi atau belum dalam proses pengerjaan. Jika sudah diproses, pembatalan harus dengan kesepakatan bersama teknisi.',
    },
];

const FAQ = () => {
    const [openIndex, setOpenIndex] = useState(0);

    return (
        <section id="faq" className="py-28 relative overflow-hidden">
            {/* Background */}
            <div className="absolute inset-0 bg-gradient-to-b from-transparent via-gray-50/40 to-transparent dark:via-white/[0.015]" />

            <div className="container mx-auto px-6 max-w-3xl relative z-10">
                {/* Header */}
                <div className="text-center mb-16">
                    <motion.div
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        className="mb-5"
                    >
                        <span className="section-label">FAQ</span>
                    </motion.div>
                    <motion.h2
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.1 }}
                        className="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-5 leading-[1.1]"
                    >
                        Pertanyaan{' '}
                        <span className="text-gradient-primary">Umum</span>
                    </motion.h2>
                    <motion.p
                        initial={{ opacity: 0, y: 12 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true }}
                        transition={{ delay: 0.2 }}
                        className="text-lg text-gray-500 dark:text-gray-400 leading-relaxed"
                    >
                        Temukan jawaban untuk pertanyaan yang sering diajukan seputar layanan kami.
                    </motion.p>
                </div>

                {/* Accordion */}
                <div className="space-y-3">
                    {faqs.map((faq, index) => (
                        <motion.div
                            key={index}
                            initial={{ opacity: 0, y: 16 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ duration: 0.4, delay: index * 0.07 }}
                        >
                            <div
                                className={cn(
                                    'bg-white/70 dark:bg-white/[0.04] backdrop-blur-md border border-white/30 dark:border-white/[0.08] rounded-2xl overflow-hidden transition-all duration-300',
                                    openIndex === index
                                        ? 'border-l-[3px] border-l-[#F53003] shadow-[0_8px_30px_rgba(245,48,3,0.08)] dark:shadow-[0_8px_30px_rgba(245,48,3,0.12)]'
                                        : 'hover:shadow-md'
                                )}
                            >
                                {/* Question button */}
                                <button
                                    className="w-full px-6 py-5 text-left flex justify-between items-center gap-4 focus:outline-none group"
                                    onClick={() => setOpenIndex(openIndex === index ? null : index)}
                                >
                                    <span className={cn(
                                        'font-semibold text-base leading-snug transition-colors duration-200',
                                        openIndex === index
                                            ? 'text-[#F53003] dark:text-orange-400'
                                            : 'text-gray-900 dark:text-white group-hover:text-gray-700 dark:group-hover:text-gray-200'
                                    )}>
                                        {faq.question}
                                    </span>

                                    {/* Animated icon — rotates to X */}
                                    <div className={cn(
                                        'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 transition-all duration-300',
                                        openIndex === index
                                            ? 'bg-gradient-to-br from-[#F53003] to-orange-400 text-white shadow-lg shadow-[#F53003]/30'
                                            : 'bg-gray-100 dark:bg-white/8 text-gray-500 dark:text-gray-400 group-hover:bg-gray-200 dark:group-hover:bg-white/12'
                                    )}>
                                        <motion.div
                                            animate={{ rotate: openIndex === index ? 45 : 0 }}
                                            transition={{ duration: 0.25, ease: 'easeInOut' }}
                                        >
                                            <Plus className="w-4 h-4" />
                                        </motion.div>
                                    </div>
                                </button>

                                {/* Answer */}
                                <AnimatePresence initial={false}>
                                    {openIndex === index && (
                                        <motion.div
                                            initial={{ height: 0, opacity: 0 }}
                                            animate={{ height: 'auto', opacity: 1 }}
                                            exit={{ height: 0, opacity: 0 }}
                                            transition={{ duration: 0.3, ease: [0.25, 0.46, 0.45, 0.94] }}
                                        >
                                            <div className="px-6 pb-6 pt-1 text-gray-500 dark:text-gray-400 leading-relaxed text-sm border-t border-gray-100/80 dark:border-white/[0.06]">
                                                {faq.answer}
                                            </div>
                                        </motion.div>
                                    )}
                                </AnimatePresence>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </div>
        </section>
    );
};

export default FAQ;
