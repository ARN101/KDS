<?php

require_once dirname(__DIR__) . '/layouts/header.php';
?>

<div class="absolute top-0 right-0 w-full h-[600px] pointer-events-none overflow-hidden z-0">
    <div class="absolute -top-[10%] right-[10%] w-[600px] h-[600px] bg-brandGreen/5 rounded-full filter blur-[150px] opacity-70"></div>
    <div class="absolute top-[40%] left-[5%] w-[400px] h-[400px] bg-brandRed/5 rounded-full filter blur-[120px] opacity-60"></div>
</div>

<section class="relative z-10 pt-20 pb-16 text-center px-6 max-w-4xl mx-auto">
    <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-3 block">Chamber Arsenal</span>
    <h1 class="font-serif text-5xl md:text-7xl font-bold tracking-tight text-white mb-6 leading-none">
        Debate <span class="italic font-light text-brandRed">Resources</span>
    </h1>
    <p class="text-sm md:text-base font-light text-gray-400 max-w-2xl mx-auto leading-relaxed tracking-wider">
        Access the knowledge base of elite chambers. Master debate structures, study previous motions, and download standard reference sheets compiled by KDS adjudicators.
    </p>
</section>

<section class="py-12 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    <div class="text-center mb-16">
        <span class="text-xs uppercase tracking-[0.2em] text-gray-500 font-semibold mb-2 block">Foundations</span>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-white">Chamber Debate Formats</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        
        <div class="spotlight-card glass-panel glass-panel-hover p-8 rounded flex flex-col justify-between min-h-[380px] transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <span class="w-2.5 h-2.5 bg-brandRed rounded-full"></span>
                    <span class="text-[9px] uppercase tracking-widest text-brandRed font-semibold">WUDC Standard</span>
                </div>
                <h3 class="font-serif text-2xl font-bold text-white mb-4">British Parliamentary</h3>
                <p class="text-xs font-light text-gray-400 leading-relaxed">
                    The premier international format consisting of four teams of two (Opening Government, Opening Opposition, Closing Government, Closing Opposition). Speakers have 7 minutes to present their points with active Points of Information (POIs) allowed between minutes 1 and 6.
                </p>
            </div>
            <div class="border-t border-white/5 pt-6 mt-6 flex justify-between items-center text-[10px] uppercase tracking-wider text-gray-500 font-mono">
                <span>8 Speakers</span>
                <span>7 Min Speeches</span>
            </div>
        </div>

        
        <div class="spotlight-card glass-panel glass-panel-hover p-8 rounded flex flex-col justify-between min-h-[380px] transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <span class="w-2.5 h-2.5 bg-brandGreen rounded-full"></span>
                    <span class="text-[9px] uppercase tracking-widest text-brandGreen font-semibold">UADC Standard</span>
                </div>
                <h3 class="font-serif text-2xl font-bold text-white mb-4">Asian Parliamentary</h3>
                <p class="text-xs font-light text-gray-400 leading-relaxed">
                    A three-on-three format involving Government (Prime Minister, Deputy Prime Minister, Government Whip) and Opposition (Leader of Opposition, Deputy Leader of Opposition, Opposition Whip). Includes structured constructive speeches and a closing reply speech from both sides.
                </p>
            </div>
            <div class="border-t border-white/5 pt-6 mt-6 flex justify-between items-center text-[10px] uppercase tracking-wider text-gray-500 font-mono">
                <span>6 Speakers</span>
                <span>7 Min + 4 Min Replies</span>
            </div>
        </div>

        
        <div class="spotlight-card glass-panel glass-panel-hover p-8 rounded flex flex-col justify-between min-h-[380px] transition-all duration-300">
            <div>
                <div class="flex items-center justify-between mb-6">
                    <span class="w-2.5 h-2.5 bg-white rounded-full"></span>
                    <span class="text-[9px] uppercase tracking-widest text-white/50 font-semibold">National Standard</span>
                </div>
                <h3 class="font-serif text-2xl font-bold text-white mb-4">Traditional format</h3>
                <p class="text-xs font-light text-gray-400 leading-relaxed">
                    Commonly practiced in Bangla national circuits. Typically a three-on-three structure emphasizing rhetorical excellence, dynamic delivery, statistics, and structured rebuttal points. It holds deep historical values across campus debate fests.
                </p>
            </div>
            <div class="border-t border-white/5 pt-6 mt-6 flex justify-between items-center text-[10px] uppercase tracking-wider text-gray-500 font-mono">
                <span>6 Speakers</span>
                <span>4 - 5 Min Speeches</span>
            </div>
        </div>

    </div>
</section>

<section class="py-24 relative z-10 border-t border-white/5 bg-gradient-to-b from-brandBlack to-darkGrey/30">
    <div class="max-w-7xl mx-auto px-6 md:px-12">
        <div class="text-center mb-16">
            <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Motion Vault</span>
            <h2 class="font-serif text-4xl md:text-5xl font-bold tracking-tight text-white">The Motion Bank</h2>
            <p class="text-xs text-gray-500 font-light mt-3 max-w-md mx-auto leading-relaxed">
                Study and build cases on these selected motions curated from international grand finals and domestic tournaments.
            </p>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            
            <div class="glass-panel p-8 rounded border-white/5 hover:border-brandRed/20 transition-all duration-300">
                <h3 class="font-serif text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-brandRed block"></span> Geopolitics & International Relations
                </h3>
                <ul class="space-y-4 text-xs font-light text-gray-400 leading-relaxed">
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would establish a permanent international security force managed by the United Nations General Assembly."
                    </li>
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House supports the rise of localized economic trading blocs over globalized trade agreements in the global south."
                    </li>
                    <li>
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would conditioning foreign financial aid solely on the recipient nation's climate adaptation performance."
                    </li>
                </ul>
            </div>

            
            <div class="glass-panel p-8 rounded border-white/5 hover:border-brandGreen/20 transition-all duration-300">
                <h3 class="font-serif text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-brandGreen block"></span> Technology, Ethics & Artificial Intelligence
                </h3>
                <ul class="space-y-4 text-xs font-light text-gray-400 leading-relaxed">
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would hold developers of autonomous systems legally responsible for the actions of their AI agents."
                    </li>
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House believes that space exploration funding should be diverted entirely to carbon capturing systems on Earth."
                    </li>
                    <li>
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would ban biometric recognition surveillance algorithms in public spaces."
                    </li>
                </ul>
            </div>

            
            <div class="glass-panel p-8 rounded border-white/5 hover:border-brandGreen/20 transition-all duration-300">
                <h3 class="font-serif text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-brandGreen block"></span> Economics & Financial Systems
                </h3>
                <ul class="space-y-4 text-xs font-light text-gray-400 leading-relaxed">
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House believes that central banks should prioritize capping wealth inequality over maintaining inflation targets."
                    </li>
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would implement a 100% inheritance tax on luxury estates above $5 Million."
                    </li>
                    <li>
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House supports the nationalization of critical domestic energy sectors in developing countries."
                    </li>
                </ul>
            </div>

            
            <div class="glass-panel p-8 rounded border-white/5 hover:border-brandRed/20 transition-all duration-300">
                <h3 class="font-serif text-xl font-bold text-white mb-6 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-brandRed block"></span> Social Justice, Culture & Media
                </h3>
                <ul class="space-y-4 text-xs font-light text-gray-400 leading-relaxed">
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would mandate public media corporations to allocate equal broadcasting time to opposing ideological arguments."
                    </li>
                    <li class="border-b border-white/5 pb-3">
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House believes that social movements should prioritize direct economic disruption over public awareness campaigns."
                    </li>
                    <li>
                        <strong class="text-white block mb-1">Motion:</strong>
                        "This House would penalize political campaigns that utilize deepfake editing tools, regardless of disclosure."
                    </li>
                </ul>
            </div>

        </div>
    </div>
</section>

<section class="py-24 relative z-10 max-w-7xl mx-auto px-6 md:px-12">
    <div class="text-center mb-16">
        <span class="text-xs uppercase tracking-[0.25em] text-brandRed font-semibold mb-2 block">Reference Guides</span>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-white">Chamber Handouts</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        
        <div class="glass-panel p-6 rounded flex items-start gap-4 hover:border-white/15 transition-all duration-300">
            <div class="w-10 h-10 border border-brandRed flex items-center justify-center font-serif text-brandRed font-bold text-lg rounded bg-brandRed/5 shrink-0">
                BP
            </div>
            <div>
                <h4 class="font-serif text-lg font-bold text-white mb-1">BP Speaking Roles Guide</h4>
                <p class="text-[11px] text-gray-400 font-light mb-4">A complete breakdown of Prime Minister, Leader of Opposition, Whips, and Extension speakers.</p>
                <a href="javascript:void(0)" onclick="alert('Downloading: BP_Speaking_Roles_KDS.pdf (Mock Link)')" class="text-[10px] uppercase tracking-widest font-bold text-brandRed hover:text-white transition-colors duration-200">
                    Download PDF &darr;
                </a>
            </div>
        </div>

        
        <div class="glass-panel p-6 rounded flex items-start gap-4 hover:border-white/15 transition-all duration-300">
            <div class="w-10 h-10 border border-brandGreen flex items-center justify-center font-serif text-brandGreen font-bold text-lg rounded bg-brandGreen/5 shrink-0">
                AP
            </div>
            <div>
                <h4 class="font-serif text-lg font-bold text-white mb-1">AP Adjudication Manual</h4>
                <p class="text-[11px] text-gray-400 font-light mb-4">Official rules guidebook outlining margins, average scores, speaker points, and debate evaluations.</p>
                <a href="javascript:void(0)" onclick="alert('Downloading: AP_Adjudication_KDS.pdf (Mock Link)')" class="text-[10px] uppercase tracking-widest font-bold text-brandGreen hover:text-white transition-colors duration-200">
                    Download PDF &darr;
                </a>
            </div>
        </div>

        
        <div class="glass-panel p-6 rounded flex items-start gap-4 hover:border-white/15 transition-all duration-300">
            <div class="w-10 h-10 border border-white/20 flex items-center justify-center font-serif text-white/60 font-bold text-lg rounded bg-white/5 shrink-0">
                MB
            </div>
            <div>
                <h4 class="font-serif text-lg font-bold text-white mb-1">KDS Motion Case File</h4>
                <p class="text-[11px] text-gray-400 font-light mb-4">A compilation of 100+ standard debate motions with context slide summaries and analyses.</p>
                <a href="javascript:void(0)" onclick="alert('Downloading: KDS_100_Motions.pdf (Mock Link)')" class="text-[10px] uppercase tracking-widest font-bold text-white hover:text-brandRed transition-colors duration-200">
                    Download PDF &darr;
                </a>
            </div>
        </div>

    </div>
</section>

<script>
    gsap.registerPlugin(ScrollTrigger);

    
    const reveals = document.querySelectorAll('.spotlight-card, .glass-panel');
    reveals.forEach(element => {
        gsap.fromTo(element, 
            { opacity: 0, y: 30 },
            { 
                scrollTrigger: {
                    trigger: element,
                    start: 'top 93%',
                    toggleActions: 'play none none none'
                },
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out'
            }
        );
    });
</script>

<?php

require_once dirname(__DIR__) . '/layouts/footer.php';
?>