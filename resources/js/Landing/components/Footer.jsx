import React, { useState } from 'react';
import { MessageCircle, Share2, Hash, Globe, Mail, MapPin, Phone, ArrowRight, Send } from 'lucide-react';

const Footer = () => {
    const [email, setEmail] = useState('');
    const [subscribed, setSubscribed] = useState(false);

    const handleSubscribe = (e) => {
        e.preventDefault();
        if (email.trim()) {
            setSubscribed(true);
            setEmail('');
        }
    };

    const socialLinks = [
        { icon: <Globe className="w-4 h-4" />, label: 'Website', color: 'hover:bg-blue-500 hover:border-blue-400' },
        { icon: <Share2 className="w-4 h-4" />, label: 'Instagram', color: 'hover:bg-pink-500 hover:border-pink-400' },
        { icon: <Hash className="w-4 h-4" />, label: 'Twitter/X', color: 'hover:bg-gray-800 hover:border-gray-600' },
        { icon: <MessageCircle className="w-4 h-4" />, label: 'WhatsApp', color: 'hover:bg-emerald-500 hover:border-emerald-400' },
    ];

    return (
        <footer className="bg-white dark:bg-[#0a0a0a] relative overflow-hidden">
            {/* Gradient top fade */}
            <div className="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-gray-200 dark:via-white/[0.07] to-transparent" />

            {/* Background decoration */}
            <div className="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-[#F53003]/3 dark:bg-[#F53003]/5 blur-[100px] rounded-full pointer-events-none" />

            <div className="container mx-auto px-6 max-w-7xl relative z-10">
                {/* ── Newsletter band ── */}
                <div className="py-14 border-b border-gray-100 dark:border-white/[0.06]">
                    <div className="flex flex-col lg:flex-row items-center justify-between gap-8">
                        <div className="text-center lg:text-left">
                            <h3 className="text-xl font-bold text-gray-900 dark:text-white mb-2">
                                Dapatkan Update Terbaru
                            </h3>
                            <p className="text-gray-500 dark:text-gray-400 text-sm">
                                Jadilah yang pertama mengetahui fitur baru dan penawaran eksklusif dari Servizz.
                            </p>
                        </div>
                        {subscribed ? (
                            <div className="flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-semibold text-sm">
                                <div className="w-5 h-5 rounded-full bg-emerald-500 flex items-center justify-center">
                                    <svg className="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={3}><path strokeLinecap="round" strokeLinejoin="round" d="M5 13l4 4L19 7" /></svg>
                                </div>
                                Terima kasih! Anda telah berlangganan.
                            </div>
                        ) : (
                            <form onSubmit={handleSubscribe} className="flex gap-2 w-full max-w-sm">
                                <div className="flex-1 relative">
                                    <Mail className="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 dark:text-gray-500" />
                                    <input
                                        type="email"
                                        value={email}
                                        onChange={(e) => setEmail(e.target.value)}
                                        placeholder="email@contoh.com"
                                        className="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-50 dark:bg-white/5 border border-gray-200 dark:border-white/10 text-gray-900 dark:text-white text-sm placeholder:text-gray-400 dark:placeholder:text-gray-600 focus:outline-none focus:border-[#F53003]/50 dark:focus:border-[#F53003]/50 focus:ring-2 focus:ring-[#F53003]/10 transition-all duration-200"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="btn-primary flex items-center gap-2 px-5 py-3 rounded-xl text-white text-sm font-semibold flex-shrink-0"
                                >
                                    <Send className="w-4 h-4" />
                                    <span className="hidden sm:inline">Subscribe</span>
                                </button>
                            </form>
                        )}
                    </div>
                </div>

                {/* ── Main footer grid ── */}
                <div className="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
                    {/* Brand column */}
                    <div className="lg:col-span-4">
                        <a href="#" className="flex items-center gap-2.5 mb-6 group w-fit">
                            <div className="w-9 h-9 rounded-xl bg-gradient-to-br from-[#F53003] to-[#c52400] flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-[#F53003]/30 group-hover:shadow-[#F53003]/50 transition-all duration-300 group-hover:scale-105">
                                S
                            </div>
                            <span className="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                Servizz
                            </span>
                        </a>
                        <p className="text-gray-500 dark:text-gray-400 mb-7 leading-relaxed max-w-xs text-sm">
                            Platform jasa terpercaya yang menghubungkan pelanggan dengan teknisi profesional untuk segala kebutuhan perbaikan.
                        </p>
                        {/* Social Icons */}
                        <div className="flex gap-2.5">
                            {socialLinks.map((social, i) => (
                                <a
                                    key={i}
                                    href="#"
                                    title={social.label}
                                    className={`group w-9 h-9 rounded-xl bg-gray-100 dark:bg-white/5 border border-gray-200/60 dark:border-white/8 flex items-center justify-center text-gray-500 dark:text-gray-500 hover:text-white dark:hover:text-white ${social.color} hover:border-transparent hover:-translate-y-0.5 transition-all duration-300 hover:shadow-lg`}
                                >
                                    {social.icon}
                                </a>
                            ))}
                        </div>
                    </div>

                    {/* Links — Perusahaan */}
                    <div className="lg:col-span-2">
                        <h4 className="font-bold text-gray-900 dark:text-white mb-6 text-sm uppercase tracking-widest">
                            Perusahaan
                        </h4>
                        <ul className="space-y-3.5">
                            {['Tentang Kami', 'Karir', 'Blog', 'Kontak'].map((link) => (
                                <li key={link}>
                                    <a
                                        href="#"
                                        className="group text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200 flex items-center gap-1.5"
                                    >
                                        <span className="h-[1px] w-0 group-hover:w-3 bg-[#F53003] transition-all duration-200 flex-shrink-0 rounded-full" />
                                        {link}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Links — Layanan */}
                    <div className="lg:col-span-2">
                        <h4 className="font-bold text-gray-900 dark:text-white mb-6 text-sm uppercase tracking-widest">
                            Layanan
                        </h4>
                        <ul className="space-y-3.5">
                            {['Cari Teknisi', 'Daftar Teknisi', 'Cara Kerja', 'Bantuan'].map((link) => (
                                <li key={link}>
                                    <a
                                        href="#"
                                        className="group text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors duration-200 flex items-center gap-1.5"
                                    >
                                        <span className="h-[1px] w-0 group-hover:w-3 bg-[#F53003] transition-all duration-200 flex-shrink-0 rounded-full" />
                                        {link}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Contact */}
                    <div className="lg:col-span-4">
                        <h4 className="font-bold text-gray-900 dark:text-white mb-6 text-sm uppercase tracking-widest">
                            Hubungi Kami
                        </h4>
                        <ul className="space-y-4">
                            {[
                                { icon: <MapPin className="w-4 h-4 flex-shrink-0" />, text: 'Jl. Sudirman No. 45, Jakarta Pusat, DKI Jakarta 10220' },
                                { icon: <Phone className="w-4 h-4 flex-shrink-0" />, text: '+62 811 2233 4455' },
                                { icon: <Mail className="w-4 h-4 flex-shrink-0" />, text: 'support@servizz.id' },
                            ].map((item, i) => (
                                <li key={i} className="flex items-start gap-3 text-gray-500 dark:text-gray-400 text-sm">
                                    <span className="mt-0.5 text-[#F53003]/70 dark:text-[#F53003]/60">{item.icon}</span>
                                    <span className="leading-relaxed">{item.text}</span>
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>

                {/* ── Bottom bar ── */}
                <div className="py-7 border-t border-gray-100 dark:border-white/[0.06] flex flex-col md:flex-row items-center justify-between gap-4">
                    <p className="text-gray-400 dark:text-gray-600 text-sm">
                        © {new Date().getFullYear()} Servizz. Hak Cipta Dilindungi.
                    </p>
                    <div className="flex items-center gap-6 text-sm">
                        <a href="#" className="text-gray-400 dark:text-gray-600 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors duration-200">
                            Privasi
                        </a>
                        <a href="#" className="text-gray-400 dark:text-gray-600 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors duration-200">
                            Syarat & Ketentuan
                        </a>
                        <a
                            href="#"
                            onClick={(e) => { e.preventDefault(); window.scrollTo({ top: 0, behavior: 'smooth' }); }}
                            className="flex items-center gap-1.5 text-gray-400 dark:text-gray-600 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors duration-200 hover:-translate-y-0.5 transition-transform"
                        >
                            Kembali ke atas
                            <ArrowRight className="w-3.5 h-3.5 -rotate-90" />
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
