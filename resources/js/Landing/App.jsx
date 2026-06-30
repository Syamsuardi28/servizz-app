import React from 'react';
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

const App = ({ loginUrl, registerUrl, dashboardUrl, isAuthenticated }) => {
    return (
        <div className="min-h-screen bg-white dark:bg-[#0a0a0a] text-gray-900 dark:text-gray-100 font-sans selection:bg-[#F53003] selection:text-white">
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
    );
};

export default App;
