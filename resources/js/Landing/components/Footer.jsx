import React from 'react';
import { MessageCircle, Share2, Hash, Globe, Mail, MapPin, Phone } from 'lucide-react';

const Footer = () => {
    return (
        <footer className="bg-white dark:bg-[#0a0a0a] border-t border-gray-200 dark:border-white/10 pt-20 pb-10">
            <div className="container mx-auto px-6 max-w-7xl">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 mb-16">
                    {/* Brand */}
                    <div className="lg:col-span-4">
                        <a href="#" className="flex items-center gap-2 mb-6">
                            <div className="w-8 h-8 rounded-lg bg-[#F53003] flex items-center justify-center text-white font-bold text-lg">
                                S
                            </div>
                            <span className="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                Servizz
                            </span>
                        </a>
                        <p className="text-gray-500 dark:text-gray-400 mb-6 leading-relaxed max-w-sm">
                            Platform jasa terpercaya yang menghubungkan pelanggan dengan teknisi profesional untuk segala kebutuhan perbaikan.
                        </p>
                        <div className="flex gap-4">
                            <a href="#" className="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-500 hover:bg-[#F53003] hover:text-white transition-all">
                                <Globe className="w-5 h-5" />
                            </a>
                            <a href="#" className="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-500 hover:bg-[#F53003] hover:text-white transition-all">
                                <Share2 className="w-5 h-5" />
                            </a>
                            <a href="#" className="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-500 hover:bg-[#F53003] hover:text-white transition-all">
                                <Hash className="w-5 h-5" />
                            </a>
                            <a href="#" className="w-10 h-10 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center text-gray-500 hover:bg-[#F53003] hover:text-white transition-all">
                                <MessageCircle className="w-5 h-5" />
                            </a>
                        </div>
                    </div>

                    {/* Links */}
                    <div className="lg:col-span-2">
                        <h4 className="font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-wider text-sm">
                            Perusahaan
                        </h4>
                        <ul className="space-y-4">
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Tentang Kami</a></li>
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Karir</a></li>
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Blog</a></li>
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Kontak</a></li>
                        </ul>
                    </div>

                    {/* Product */}
                    <div className="lg:col-span-2">
                        <h4 className="font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-wider text-sm">
                            Layanan
                        </h4>
                        <ul className="space-y-4">
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Cari Teknisi</a></li>
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Daftar Teknisi</a></li>
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Cara Kerja</a></li>
                            <li><a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003] dark:hover:text-[#F53003] transition-colors">Bantuan</a></li>
                        </ul>
                    </div>

                    {/* Contact */}
                    <div className="lg:col-span-4">
                        <h4 className="font-bold text-gray-900 dark:text-white mb-6 uppercase tracking-wider text-sm">
                            Hubungi Kami
                        </h4>
                        <ul className="space-y-4">
                            <li className="flex gap-3 text-gray-500 dark:text-gray-400">
                                <MapPin className="w-5 h-5 shrink-0" />
                                <span>Jl. Sudirman No. 45, Jakarta Pusat, DKI Jakarta 10220</span>
                            </li>
                            <li className="flex gap-3 text-gray-500 dark:text-gray-400">
                                <Phone className="w-5 h-5 shrink-0" />
                                <span>+62 811 2233 4455</span>
                            </li>
                            <li className="flex gap-3 text-gray-500 dark:text-gray-400">
                                <Mail className="w-5 h-5 shrink-0" />
                                <span>support@servizz.id</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div className="border-t border-gray-200 dark:border-white/10 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
                    <p className="text-gray-500 dark:text-gray-400 text-sm">
                        &copy; {new Date().getFullYear()} Servizz. Hak Cipta Dilindungi.
                    </p>
                    <div className="flex gap-6 text-sm">
                        <a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003]">Privasi</a>
                        <a href="#" className="text-gray-500 dark:text-gray-400 hover:text-[#F53003]">Syarat & Ketentuan</a>
                    </div>
                </div>
            </div>
        </footer>
    );
};

export default Footer;
