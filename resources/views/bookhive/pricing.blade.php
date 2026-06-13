@extends("layouts.master")

@section("title", "BookHive - Choose Your Plan")

@section("content")
<style>
  .pricing-header {
    background: linear-gradient(135deg, var(--deep-teal) 0%, #1e4543 100%);
    color: white;
    padding: 5rem 0 7rem;
    text-align: center;
    position: relative;
  }
  
  .pricing-header h1 {
    font-family: 'Dancing Script', cursive;
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }
  
  .pricing-header p {
    font-size: 1.2rem;
    font-weight: 300;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.9;
  }

  .pricing-container {
    margin-top: -5rem;
    position: relative;
    z-index: 10;
    padding-bottom: 5rem;
  }

  .billing-toggle-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-bottom: 3rem;
  }

  .billing-label {
    font-weight: 600;
    color: white;
    cursor: pointer;
  }

  .billing-label.inactive {
    opacity: 0.6;
    color: rgba(255, 255, 255, 0.8);
  }

  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--soft-sage);
    transition: .4s;
    border-radius: 34px;
    border: 2px solid white;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
  }

  input:checked + .slider {
    background-color: var(--warm-terracotta);
  }

  input:checked + .slider:before {
    transform: translateX(26px);
  }

  .pricing-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow: hidden;
  }

  .pricing-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
  }

  .pricing-card.featured {
    border: 3px solid var(--warm-terracotta);
    transform: scale(1.03);
    position: relative;
  }
  
  .pricing-card.featured:hover {
    transform: scale(1.03) translateY(-10px);
  }

  .featured-badge {
    position: absolute;
    top: 0;
    right: 0;
    background-color: var(--warm-terracotta);
    color: white;
    padding: 0.5rem 1.5rem;
    font-size: 0.8rem;
    font-weight: 600;
    border-bottom-left-radius: 15px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .pricing-card-header {
    padding: 2.5rem 2rem 1.5rem;
    text-align: center;
    background-color: rgba(0,0,0,0.01);
    border-bottom: 1px solid rgba(0,0,0,0.03);
  }

  .plan-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--charcoal);
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }

  .plan-price-wrapper {
    margin: 1.5rem 0;
    color: var(--oxblood);
  }

  .currency {
    font-size: 1.8rem;
    font-weight: 600;
    vertical-align: top;
    position: relative;
    top: -5px;
  }

  .price {
    font-size: 3.5rem;
    font-weight: 700;
    line-height: 1;
  }

  .period {
    font-size: 1rem;
    color: #666;
    font-weight: 400;
  }

  .pricing-card-body {
    padding: 2rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
  }

  .features-list {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem;
    text-align: left;
    flex-grow: 1;
  }

  .features-list li {
    padding: 0.75rem 0;
    border-bottom: 1px solid rgba(0,0,0,0.03);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.95rem;
  }

  .features-list li:last-child {
    border-bottom: none;
  }

  .features-list li i {
    color: var(--deep-teal);
    font-size: 1.1rem;
  }

  .features-list li i.fa-times-circle {
    color: #ccc;
  }

  .features-list li.ai-feature {
    font-weight: 600;
    color: var(--deep-teal);
  }

  .features-list li.ai-feature i {
    color: var(--warm-terracotta);
  }

  .btn-pricing {
    font-weight: 600;
    padding: 0.85rem 1.5rem;
    border-radius: 8px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: background-color 0.2s, border-color 0.2s;
    width: 100%;
  }

  .btn-free {
    background-color: transparent;
    border: 2px solid var(--deep-teal);
    color: var(--deep-teal);
  }

  .btn-free:hover {
    background-color: var(--deep-teal);
    color: white;
  }

  .btn-pro {
    background-color: var(--warm-terracotta);
    border: 2px solid var(--warm-terracotta);
    color: white;
  }

  .btn-pro:hover {
    background-color: #b55d3f;
    border-color: #b55d3f;
    color: white;
  }

  .btn-premium {
    background-color: var(--deep-teal);
    border: 2px solid var(--deep-teal);
    color: white;
  }

  .btn-premium:hover {
    background-color: #1e4543;
    border-color: #1e4543;
    color: white;
  }

  .faq-section {
    padding: 5rem 0;
    background-color: white;
    border-top: 1px solid rgba(0,0,0,0.05);
  }

  .faq-title {
    font-family: 'Dancing Script', cursive;
    color: var(--oxblood);
    font-size: 2.5rem;
    margin-bottom: 3rem;
    text-align: center;
  }

  .accordion-button:not(.collapsed) {
    background-color: rgba(42, 92, 90, 0.05);
    color: var(--deep-teal);
  }

  .accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(42, 92, 90, 0.25);
    border-color: var(--deep-teal);
  }
  
  .badge-ai-pill {
    background-color: rgba(199, 107, 74, 0.15);
    color: var(--warm-terracotta);
    font-size: 0.75rem;
    padding: 0.15rem 0.5rem;
    border-radius: 10px;
    font-weight: 600;
  }
</style>

<!-- Header -->
<div class="pricing-header">
  <div class="container">
    <h1>Simple, SaaS-based Pricing</h1>
    <p>Get unlimited access to community features, bookshelves, and state-of-the-art AI recommendation services.</p>
  </div>
</div>

<!-- Pricing Section -->
<div class="pricing-container">
  <div class="container">
    
    <!-- Billing Toggle -->
    <div class="billing-toggle-wrapper">
      <span class="billing-label" id="monthly-label">Monthly</span>
      <label class="switch">
        <input type="checkbox" id="pricing-toggle">
        <span class="slider"></span>
      </label>
      <span class="billing-label inactive" id="annual-label">
        Annually <span class="badge bg-success ms-1">Save 20%</span>
      </span>
    </div>

    <!-- Pricing Cards -->
    <div class="row g-4 align-items-stretch justify-content-center">
      
      <!-- Free Plan -->
      <div class="col-lg-4 col-md-6">
        <div class="pricing-card">
          <div class="pricing-card-header">
            <div class="plan-name">Reader</div>
            <p class="text-muted small">Ideal for casual readers getting started</p>
            <div class="plan-price-wrapper">
              <span class="currency">$</span>
              <span class="price">0</span>
              <span class="period">/ month</span>
            </div>
          </div>
          <div class="pricing-card-body">
            <ul class="features-list">
              <li><i class="fas fa-check-circle"></i> Create personal bookshelves</li>
              <li><i class="fas fa-check-circle"></i> Log up to 5 books in library</li>
              <li><i class="fas fa-check-circle"></i> Browse public book logs</li>
              <li><i class="fas fa-check-circle"></i> Read and post standard reviews</li>
              <li><i class="fas fa-times-circle text-muted"></i> <span class="text-muted">AI-powered recommendations</span></li>
              <li><i class="fas fa-times-circle text-muted"></i> <span class="text-muted">Instant AI Book Summaries</span></li>
              <li><i class="fas fa-times-circle text-muted"></i> <span class="text-muted">Ad-free dashboard</span></li>
            </ul>
            <a href="{{ route('register') }}" class="btn btn-pricing btn-free mt-auto">Get Started</a>
          </div>
        </div>
      </div>

      <!-- Pro Plan (Most Popular) -->
      <div class="col-lg-4 col-md-6">
        <div class="pricing-card featured">
          <div class="featured-badge">Most Popular</div>
          <div class="pricing-card-header">
            <div class="plan-name">Bookworm Pro</div>
            <p class="text-muted small">For enthusiastic readers and literary fans</p>
            <div class="plan-price-wrapper">
              <span class="currency">$</span>
              <span class="price" id="pro-price" data-monthly="4.99" data-annual="3.99">4.99</span>
              <span class="period">/ month</span>
            </div>
          </div>
          <div class="pricing-card-body">
            <ul class="features-list">
              <li><i class="fas fa-check-circle"></i> <strong>Unlimited</strong> bookshelves & logs</li>
              <li class="ai-feature">
                <i class="fas fa-robot"></i> 
                <span>AI Recommendations</span> 
                <span class="badge-ai-pill">AWS Bedrock</span>
              </li>
              <li class="ai-feature">
                <i class="fas fa-magic"></i> 
                <span>Instant AI Summaries</span> 
                <span class="badge-ai-pill">AWS Bedrock</span>
              </li>
              <li><i class="fas fa-check-circle"></i> Ad-free library experience</li>
              <li><i class="fas fa-check-circle"></i> Exclusive community badge</li>
              <li><i class="fas fa-check-circle"></i> Priority customer support</li>
              <li><i class="fas fa-times-circle text-muted"></i> <span class="text-muted">AI Sentiment Analysis</span></li>
            </ul>
            <a href="{{ route('register') }}" class="btn btn-pricing btn-pro mt-auto">Start 14-Day Trial</a>
          </div>
        </div>
      </div>

      <!-- Premium Plan -->
      <div class="col-lg-4 col-md-6">
        <div class="pricing-card">
          <div class="pricing-card-header">
            <div class="plan-name">Scholar</div>
            <p class="text-muted small">For professional writers, research, and API users</p>
            <div class="plan-price-wrapper">
              <span class="currency">$</span>
              <span class="price" id="premium-price" data-monthly="9.99" data-annual="7.99">9.99</span>
              <span class="period">/ month</span>
            </div>
          </div>
          <div class="pricing-card-body">
            <ul class="features-list">
              <li><i class="fas fa-check-circle"></i> Everything in Pro plan</li>
              <li class="ai-feature">
                <i class="fas fa-brain"></i> 
                <span>Review Sentiment Analyzer</span>
                <span class="badge-ai-pill">NLP</span>
              </li>
              <li class="ai-feature">
                <i class="fas fa-comments"></i> 
                <span>AI Reading Companion Chat</span>
                <span class="badge-ai-pill">Claude 3.5</span>
              </li>
              <li><i class="fas fa-check-circle"></i> Export reading logs to CSV/JSON</li>
              <li><i class="fas fa-check-circle"></i> Developer API integration access</li>
              <li><i class="fas fa-check-circle"></i> Early access to experimental AI features</li>
              <li><i class="fas fa-check-circle"></i> 24/7 Dedicated account representative</li>
            </ul>
            <a href="{{ route('register') }}" class="btn btn-pricing btn-premium mt-auto">Upgrade to Scholar</a>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- FAQ Section -->
<div class="faq-section">
  <div class="container">
    <h2 class="faq-title">Frequently Asked Questions</h2>
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="accordion" id="pricingFaqAccordion">
          
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                How does the AI recommendation system work?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#pricingFaqAccordion">
              <div class="accordion-body">
                Our recommendation engine uses **AWS Bedrock** to run secure, advanced Large Language Models (specifically Claude 3.5 Sonnet). It analyzes your reading logs, favorites, and written reviews to map out a semantic profile of your taste, comparing it with community insights to recommend books that match your preferences perfectly.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                Are my reading data and summaries secure?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#pricingFaqAccordion">
              <div class="accordion-body">
                Absolutely. Because our AI infrastructure is built entirely on **AWS**, we benefit from enterprise-grade security. All requests processed through AWS Bedrock are encrypted in transit and at rest. Your private reviews and personal bookshelves are never used to train public models.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                Can I switch between monthly and annual plans?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#pricingFaqAccordion">
              <div class="accordion-body">
                Yes, you can upgrade, downgrade, or switch between billing periods at any time directly through your dashboard settings. If you upgrade to an annual plan, your savings will be prorated immediately.
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                Do you offer a trial period for paid tiers?
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#pricingFaqAccordion">
              <div class="accordion-body">
                Yes! We offer a 14-day free trial on our Bookworm Pro plan. You can access all Pro features, including unlimited bookshelves and AWS Bedrock AI summaries, risk-free. Cancel anytime before the trial ends and you won't be charged.
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('pricing-toggle');
    const proPrice = document.getElementById('pro-price');
    const premiumPrice = document.getElementById('premium-price');
    const monthlyLabel = document.getElementById('monthly-label');
    const annualLabel = document.getElementById('annual-label');

    toggle.addEventListener('change', function() {
      if (this.checked) {
        // Annual billing
        proPrice.textContent = proPrice.getAttribute('data-annual');
        premiumPrice.textContent = premiumPrice.getAttribute('data-annual');
        monthlyLabel.classList.add('inactive');
        annualLabel.classList.remove('inactive');
      } else {
        // Monthly billing
        proPrice.textContent = proPrice.getAttribute('data-monthly');
        premiumPrice.textContent = premiumPrice.getAttribute('data-monthly');
        monthlyLabel.classList.remove('inactive');
        annualLabel.classList.add('inactive');
      }
    });

    // Make labels clickable
    monthlyLabel.addEventListener('click', function() {
      if (toggle.checked) {
        toggle.checked = false;
        toggle.dispatchEvent(new Event('change'));
      }
    });

    annualLabel.addEventListener('click', function() {
      if (!toggle.checked) {
        toggle.checked = true;
        toggle.dispatchEvent(new Event('change'));
      }
    });
  });
</script>
@endsection

@endsection
