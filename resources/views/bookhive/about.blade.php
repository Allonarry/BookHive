@extends("layouts.master")

@section("title", "BookHive - About Us")

@section("content")
<style>
  .about-header {
    background: linear-gradient(135deg, var(--deep-teal) 0%, #1e4543 100%);
    color: white;
    padding: 5rem 0;
    text-align: center;
    margin-bottom: 4rem;
  }
  
  .about-header h1 {
    font-family: 'Dancing Script', cursive;
    font-size: 3.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
  }
  
  .about-header p {
    font-size: 1.2rem;
    font-weight: 300;
    max-width: 600px;
    margin: 0 auto;
    opacity: 0.9;
  }

  .section-heading {
    font-family: 'Dancing Script', cursive;
    color: var(--oxblood);
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
  }

  .section-heading:after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    width: 60%;
    height: 3px;
    background-color: var(--soft-sage);
  }

  .about-card {
    background: white;
    border-radius: 12px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    border: 1px solid rgba(0,0,0,0.02);
    height: 100%;
  }

  .team-member-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.03);
    text-align: center;
    transition: transform 0.3s ease;
    height: 100%;
  }

  .team-member-card:hover {
    transform: translateY(-5px);
  }

  .team-avatar {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    margin: 2.5rem auto 1.5rem;
    border: 5px solid var(--ivory);
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  }

  .team-info {
    padding: 0 1.5rem 2.5rem;
  }

  .team-name {
    font-weight: 600;
    color: var(--oxblood);
    margin-bottom: 0.25rem;
    font-size: 1.25rem;
  }

  .team-role {
    color: var(--deep-teal);
    font-weight: 500;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
  }

  .team-bio {
    font-size: 0.9rem;
    color: #666;
    line-height: 1.6;
  }

  .tech-stack-section {
    background-color: white;
    padding: 5rem 0;
    border-top: 1px solid rgba(0,0,0,0.05);
    border-bottom: 1px solid rgba(0,0,0,0.05);
    margin-top: 4rem;
  }

  .tech-card {
    padding: 2rem;
    text-align: center;
    background-color: var(--ivory);
    border-radius: 10px;
    height: 100%;
    transition: background-color 0.2s;
  }

  .tech-card:hover {
    background-color: #f1ede6;
  }

  .tech-icon {
    font-size: 2.5rem;
    color: var(--warm-terracotta);
    margin-bottom: 1rem;
  }

  .tech-title {
    font-weight: 600;
    color: var(--charcoal);
    margin-bottom: 0.5rem;
  }

  .tech-desc {
    font-size: 0.85rem;
    color: #666;
  }
</style>

<!-- Header -->
<div class="about-header">
  <div class="container">
    <h1>Our Story & Mission</h1>
    <p>Empowering readers to explore books and share literary journeys through community and Generative AI.</p>
  </div>
</div>

<!-- Main Body -->
<div class="container my-5">
  <div class="row g-4 align-items-stretch">
    
    <!-- Our Story -->
    <div class="col-md-6">
      <div class="about-card">
        <h2 class="section-heading">How BookHive Began</h2>
        <p class="mt-4 leading-relaxed">
          Founded in **2025**, BookHive was born out of a simple shared problem: with millions of books in print, discovering your next favorite book is often a game of chance. Traditional algorithms recommend books based solely on generic categories or simple rating averages, which misses the personal relationship readers have with books.
        </p>
        <p class="leading-relaxed">
          Our team set out to build a platform that pairs the warmth of a social book club with state-of-the-art **Natural Language Processing (NLP)** and **Generative AI** recommendation technologies. We believe that technology should bring readers together and enhance, rather than replace, the human connection to stories.
        </p>
      </div>
    </div>

    <!-- Our Mission -->
    <div class="col-md-6">
      <div class="about-card">
        <h2 class="section-heading">Our Mission</h2>
        <p class="mt-4 leading-relaxed">
          At BookHive, our mission is to build the world's most interactive and intuitive bookshelf. We aim to help authors, students, and casual readers organize their libraries, share deep reviews, and uncover exact matches for their next reads.
        </p>
        <p class="leading-relaxed">
          By leveraging security-first cloud infrastructures and intelligent models, we provide real-time book analysis, spoiler-free AI summaries, and sentiment mapping on reader reviews. We're committed to creating a vibrant, safe, and positive space for book lovers globally.
        </p>
      </div>
    </div>

  </div>
</div>

<!-- AWS Tech Stack Section -->
<div class="tech-stack-section">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="section-heading">Our AWS-Powered Cloud Stack</h2>
      <p class="text-muted max-w-600 mx-auto">BookHive is architected to scale globally. We leverage Amazon Web Services (AWS) to guarantee fast page loads, high availability, and secure AI processing.</p>
    </div>
    
    <div class="row g-4">
      
      <!-- AWS Bedrock -->
      <div class="col-md-3 col-sm-6">
        <div class="tech-card">
          <div class="tech-icon"><i class="fas fa-brain"></i></div>
          <div class="tech-title">AWS Bedrock</div>
          <div class="tech-desc">Orchestrates our Large Language Models (Claude 3.5 Sonnet) securely to generate summaries and smart recommendations.</div>
        </div>
      </div>

      <!-- AWS ECS -->
      <div class="col-md-3 col-sm-6">
        <div class="tech-card">
          <div class="tech-icon"><i class="fas fa-server"></i></div>
          <div class="tech-title">Amazon ECS</div>
          <div class="tech-desc">Deploys our Laravel application in Docker containers, utilizing AWS Fargate for serverless scaling.</div>
        </div>
      </div>

      <!-- AWS RDS -->
      <div class="col-md-3 col-sm-6">
        <div class="tech-card">
          <div class="tech-icon"><i class="fas fa-database"></i></div>
          <div class="tech-title">Amazon RDS</div>
          <div class="tech-desc">Hosts our highly optimized PostgreSQL database containing logs, genres, and community review structures.</div>
        </div>
      </div>

      <!-- AWS S3 & CloudFront -->
      <div class="col-md-3 col-sm-6">
        <div class="tech-card">
          <div class="tech-icon"><i class="fas fa-cloud-upload-alt"></i></div>
          <div class="tech-title">S3 & CloudFront</div>
          <div class="tech-desc">Stores all user-uploaded book covers and dynamically delivers static assets around the globe via CDN.</div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Team Section -->
<div class="container my-5 py-4">
  <div class="text-center mb-5">
    <h2 class="section-heading">Meet the Team</h2>
    <p class="text-muted">The readers, developers, and creators building BookHive every day.</p>
  </div>
  
  <div class="row g-4 justify-content-center">
    
    <!-- Qudus -->
    <div class="col-lg-4 col-md-6">
      <div class="team-member-card">
        <img src="https://randomuser.me/api/portraits/men/86.jpg" class="team-avatar" alt="Qudus">
        <div class="team-info">
          <div class="team-name">Qudus</div>
          <div class="team-role">Founder & CEO</div>
          <div class="team-bio">An avid collector of non-fiction and a seasoned full-stack developer, Qudus founded BookHive to merge his love of reading with modern web applications.</div>
        </div>
      </div>
    </div>

    <!-- Sarah Chen -->
    <div class="col-lg-4 col-md-6">
      <div class="team-member-card">
        <img src="https://randomuser.me/api/portraits/women/44.jpg" class="team-avatar" alt="Sarah Chen">
        <div class="team-info">
          <div class="team-name">Sarah Chen</div>
          <div class="team-role">Head of AI & NLP</div>
          <div class="team-bio">With a master's degree in Computer Science and years of experience building scalable NLP pipelines, Sarah leads our AWS Bedrock LLM integrations and recommendation systems.</div>
        </div>
      </div>
    </div>

    <!-- Marcus Johnson -->
    <div class="col-lg-4 col-md-6">
      <div class="team-member-card">
        <img src="https://randomuser.me/api/portraits/men/62.jpg" class="team-avatar" alt="Marcus Johnson">
        <div class="team-info">
          <div class="team-name">Marcus Johnson</div>
          <div class="team-role">Lead UX Designer</div>
          <div class="team-bio">Marcus focuses on human-centered design. He shapes the visuals and workflows of BookHive, ensuring bookshelves are beautiful and discussions flow smoothly.</div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
