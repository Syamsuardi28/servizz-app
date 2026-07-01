import React, { useState } from 'react';
import Navbar from './components/Navbar';
import Hero from './components/Hero';
import TrustedBy from './components/TrustedBy';
import Statistics from './components/Statistics';
import Features from './components/Features';
import HowItWorks from './components/HowItWorks';
import DashboardPreview from './components/DashboardPreview';
import Benefits from './components/Benefits';
import Testimonials from './components/Testimonials';
import FAQ from './components/FAQ';
import CTA from './components/CTA';
import Footer from './components/Footer';
import ScrollToTop from './components/ScrollToTop';
import LoadingScreen from './components/LoadingScreen';

const App = ({ loginUrl, registerUrl, dashboardUrl, isAuthenticated }) => {
    const [isLoading, setIsLoading] = useState(true);

    return (
        <div className="min-h-screen bg-white dark:bg-[#0a0a0a] text-gray-900 dark:text-gray-100 font-sans selection:bg-[#F53003] selection:text-white scroll-smooth overflow-x-hidden">
            {isLoading && <LoadingScreen onComplete={() => setIsLoading(false)} />}
            
            <div className={`transition-all duration-1000 ease-out-expo ${isLoading ? 'opacity-0 scale-95 blur-md' : 'opacity-100 scale-100 blur-0'}`}>
            {/* Global decorative background */}
            <div className="fixed inset-0 pointer-events-none -z-50 overflow-hidden">
                {/* Top-left ambient glow */}
                <div className="absolute -top-64 -left-64 w-[700px] h-[700px] rounded-full bg-[#F53003]/5 dark:bg-[#F53003]/8 blur-[140px]" />
                {/* Top-right ambient glow */}
                <div className="absolute -top-32 -right-64 w-[600px] h-[600px] rounded-full bg-amber-400/5 dark:bg-amber-500/6 blur-[120px]" />
                {/* Bottom ambient */}
                <div className="absolute bottom-0 left-1/3 w-[500px] h-[400px] rounded-full bg-[#F53003]/3 dark:bg-[#F53003]/5 blur-[100px]" />
                {/* Noise texture overlay */}
                <div
                    className="absolute inset-0 opacity-[0.015] dark:opacity-[0.03]"
                    style={{
                        backgroundImage: `url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='1'/%3E%3C/svg%3E")`,
                        backgroundRepeat: 'repeat',
                        backgroundSize: '128px',
                    }}
                />
            </div>

            <style>{`
                @keyframes shimmer {
                    0% { background-position: -200% center; }
                    100% { background-position: 200% center; }
                }
                @keyframes float {
                    0%, 100% { transform: translateY(0px) rotate(0deg); }
                    33% { transform: translateY(-12px) rotate(1deg); }
                    66% { transform: translateY(-6px) rotate(-1deg); }
                }
                @keyframes float-reverse {
                    0%, 100% { transform: translateY(0px) rotate(0deg); }
                    33% { transform: translateY(10px) rotate(-1deg); }
                    66% { transform: translateY(5px) rotate(1deg); }
                }
                @keyframes gradient-shift {
                    0%, 100% { background-position: 0% 50%; }
                    50% { background-position: 100% 50%; }
                }
                @keyframes marquee {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                @keyframes pulse-glow {
                    0%, 100% { box-shadow: 0 0 20px rgba(245,48,3,0.3); }
                    50% { box-shadow: 0 0 40px rgba(245,48,3,0.6), 0 0 60px rgba(245,48,3,0.2); }
                }
                @keyframes border-rotate {
                    from { --angle: 0deg; }
                    to { --angle: 360deg; }
                }
                @keyframes count-up {
                    from { opacity: 0; transform: translateY(10px); }
                    to { opacity: 1; transform: translateY(0); }
                }
                .animate-shimmer {
                    background-size: 200% auto;
                    animation: shimmer 3s linear infinite;
                }
                .animate-float {
                    animation: float 6s ease-in-out infinite;
                }
                .animate-float-reverse {
                    animation: float-reverse 7s ease-in-out infinite;
                }
                .animate-gradient-shift {
                    background-size: 300% 300%;
                    animation: gradient-shift 8s ease infinite;
                }
                .animate-marquee {
                    animation: marquee 30s linear infinite;
                }
                .animate-pulse-glow {
                    animation: pulse-glow 3s ease-in-out infinite;
                }

                .text-gradient-primary {
                    background: linear-gradient(135deg, #F53003, #ff6b35, #f59e0b);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }
                .hover-lift {
                    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
                }
                .hover-lift:hover {
                    transform: translateY(-6px);
                }
                .btn-primary {
                    background: linear-gradient(135deg, #F53003 0%, #e02a02 100%);
                    box-shadow: 0 4px 15px rgba(245,48,3,0.35), 0 1px 3px rgba(0,0,0,0.1);
                    transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
                }
                .btn-primary:hover {
                    box-shadow: 0 8px 25px rgba(245,48,3,0.5), 0 2px 6px rgba(0,0,0,0.15);
                    transform: translateY(-2px) scale(1.02);
                }
                .btn-primary:active {
                    transform: translateY(0) scale(0.98);
                    box-shadow: 0 2px 8px rgba(245,48,3,0.3);
                }
                .section-label {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    padding: 6px 14px;
                    border-radius: 100px;
                    background: linear-gradient(135deg, rgba(245,48,3,0.1), rgba(245,100,3,0.08));
                    border: 1px solid rgba(245,48,3,0.2);
                    font-size: 12px;
                    font-weight: 600;
                    letter-spacing: 0.08em;
                    text-transform: uppercase;
                    color: #F53003;
                }
                html.dark .section-label {
                    background: linear-gradient(135deg, rgba(245,48,3,0.15), rgba(245,100,3,0.1));
                    border-color: rgba(245,48,3,0.3);
                    color: #ff6b35;
                }
                @media (prefers-color-scheme: dark) {
                    html:not(.light) .section-label {
                        background: linear-gradient(135deg, rgba(245,48,3,0.15), rgba(245,100,3,0.1));
                        border-color: rgba(245,48,3,0.3);
                        color: #ff6b35;
                    }
                }
                .card-hover-border {
                    position: relative;
                    isolation: isolate;
                }
                .card-hover-border::before {
                    content: '';
                    position: absolute;
                    inset: 0;
                    border-radius: inherit;
                    padding: 1px;
                    background: linear-gradient(135deg, rgba(245,48,3,0), rgba(245,48,3,0.5), rgba(245,48,3,0));
                    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
                    -webkit-mask-composite: xor;
                    mask-composite: exclude;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                .card-hover-border:hover::before {
                    opacity: 1;
                }
            `}</style>

            <Navbar
                loginUrl={loginUrl}
                registerUrl={registerUrl}
                dashboardUrl={dashboardUrl}
                isAuthenticated={isAuthenticated}
            />

            <main>
                <Hero loginUrl={loginUrl} registerUrl={registerUrl} />
                <TrustedBy />
                <Statistics />
                <Features />
                <HowItWorks />
                <DashboardPreview />
                <Benefits />
                <Testimonials />
                <FAQ />
                <CTA loginUrl={loginUrl} registerUrl={registerUrl} />
            </main>

            <Footer />
            <ScrollToTop />
            </div>
        </div>
    );
};

export default App;
