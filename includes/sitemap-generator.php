<?php
/**
 * Kavya Prop - Sitemap Generation Utility
 * Developed by Expert Developer
 */

if (!function_exists('generateSitemaps')) {
    function generateSitemaps($pdo) {
        $baseUrl = 'https://kavyaprop.com/';
        $currentDate = date('c');

        // 1. Core static pages configuration
        $staticPages = [
            ['loc' => '', 'priority' => '1.0', 'changefreq' => 'daily', 'file' => 'index.php', 'title' => 'Home Page'],
            ['loc' => 'projects.php', 'priority' => '0.8', 'changefreq' => 'weekly', 'file' => 'projects.php', 'title' => 'Dholera Smart City Projects'],
            ['loc' => 'dholera-sir.php', 'priority' => '0.8', 'changefreq' => 'monthly', 'file' => 'dholera-sir.php', 'title' => 'About Dholera SIR'],
            ['loc' => 'about.php', 'priority' => '0.5', 'changefreq' => 'monthly', 'file' => 'about.php', 'title' => 'About Us - Kavya Prop'],
            ['loc' => 'contact.php', 'priority' => '0.5', 'changefreq' => 'monthly', 'file' => 'contact.php', 'title' => 'Contact Us / Reach Agent']
        ];

        // 2. Fetch projects dynamically from the database
        try {
            $stmt = $pdo->query("SELECT id, title, category, created_at, seo_title FROM projects ORDER BY id DESC");
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $projects = [];
        }

        // 3. GENERATE XML SITEMAP
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Static Pages XML URLs
        foreach ($staticPages as $page) {
            $filePath = __DIR__ . '/../' . $page['file'];
            $lastmod = file_exists($filePath) ? date('c', filemtime($filePath)) : $currentDate;

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . $page['loc']) . "</loc>\n";
            $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>" . $page['changefreq'] . "</changefreq>\n";
            $xml .= "    <priority>" . $page['priority'] . "</priority>\n";
            $xml .= "  </url>\n";
        }

        // Dynamic Projects XML URLs
        foreach ($projects as $project) {
            $lastmod = !empty($project['created_at']) ? date('c', strtotime($project['created_at'])) : $currentDate;

            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($baseUrl . 'project-details.php?id=' . $project['id']) . "</loc>\n";
            $xml .= "    <lastmod>" . $lastmod . "</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.7</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        // Write XML sitemap to root
        @file_put_contents(__DIR__ . '/../sitemap.xml', $xml);


        // 4. GENERATE PREMIUM STATIC HTML SITEMAP
        // Group projects by category for clean visual hierarchy
        $categorizedProjects = [];
        foreach ($projects as $project) {
            $cat = $project['category'] ?: 'Other Projects';
            $categorizedProjects[$cat][] = $project;
        }

        // Build HTML template
        $html = '<!DOCTYPE html>' . "\n";
        $html .= '<html lang="en">' . "\n";
        $html .= '<head>' . "\n";
        $html .= '  <meta charset="UTF-8">' . "\n";
        $html .= '  <meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
        $html .= '  <title>Kavya Prop - HTML Site Directory Sitemap</title>' . "\n";
        $html .= '  <meta name="description" content="Explore Dholera Smart City projects directory. Find residential plots, commercial spaces, and industrial land details in our sitemap.">' . "\n";
        $html .= '  <link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
        $html .= '  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
        $html .= '  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">' . "\n";
        $html .= '  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">' . "\n";
        $html .= '  <style>' . "\n";
        $html .= '    :root {' . "\n";
        $html .= '      --dh-orange: #ef7d00;' . "\n";
        $html .= '      --dh-orange-hover: #d46c00;' . "\n";
        $html .= '      --dh-green: #2b6009;' . "\n";
        $html .= '      --dh-dark: #1e293b;' . "\n";
        $html .= '      --dh-bg: #f8fafc;' . "\n";
        $html .= '      --dh-card-bg: #ffffff;' . "\n";
        $html .= '      --dh-text: #334155;' . "\n";
        $html .= '      --dh-text-light: #64748b;' . "\n";
        $html .= '      --dh-border: #e2e8f0;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    * { box-sizing: border-box; margin: 0; padding: 0; }' . "\n";
        $html .= '    body {' . "\n";
        $html .= '      font-family: "Outfit", sans-serif;' . "\n";
        $html .= '      background-color: var(--dh-bg);' . "\n";
        $html .= '      color: var(--dh-text);' . "\n";
        $html .= '      line-height: 1.6;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-header {' . "\n";
        $html .= '      background: linear-gradient(135deg, var(--dh-green) 0%, #1e4505 100%);' . "\n";
        $html .= '      color: #ffffff;' . "\n";
        $html .= '      padding: 60px 20px;' . "\n";
        $html .= '      text-align: center;' . "\n";
        $html .= '      position: relative;' . "\n";
        $html .= '      overflow: hidden;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-header::after {' . "\n";
        $html .= '      content: "";' . "\n";
        $html .= '      position: absolute;' . "\n";
        $html .= '      top: -50%;' . "\n";
        $html .= '      left: -50%;' . "\n";
        $html .= '      width: 200%;' . "\n";
        $html .= '      height: 200%;' . "\n";
        $html .= '      background: radial-gradient(circle, rgba(239,125,0,0.15) 0%, transparent 60%);' . "\n";
        $html .= '      pointer-events: none;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-header h1 {' . "\n";
        $html .= '      font-family: "Montserrat", sans-serif;' . "\n";
        $html .= '      font-size: 2.5rem;' . "\n";
        $html .= '      font-weight: 800;' . "\n";
        $html .= '      margin-bottom: 12px;' . "\n";
        $html .= '      letter-spacing: -0.5px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-header p {' . "\n";
        $html .= '      font-size: 1.1rem;' . "\n";
        $html .= '      opacity: 0.9;' . "\n";
        $html .= '      max-width: 600px;' . "\n";
        $html .= '      margin: 0 auto;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-container {' . "\n";
        $html .= '      max-width: 1200px;' . "\n";
        $html .= '      margin: 40px auto;' . "\n";
        $html .= '      padding: 0 20px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-grid {' . "\n";
        $html .= '      display: grid;' . "\n";
        $html .= '      grid-template-columns: 1fr 1.8fr;' . "\n";
        $html .= '      gap: 40px;' . "\n";
        $html .= '      align-items: start;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-card {' . "\n";
        $html .= '      background-color: var(--dh-card-bg);' . "\n";
        $html .= '      border: 1px solid var(--dh-border);' . "\n";
        $html .= '      border-radius: 16px;' . "\n";
        $html .= '      padding: 30px;' . "\n";
        $html .= '      box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.02);' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .card-title {' . "\n";
        $html .= '      font-family: "Montserrat", sans-serif;' . "\n";
        $html .= '      font-size: 1.35rem;' . "\n";
        $html .= '      font-weight: 700;' . "\n";
        $html .= '      color: var(--dh-dark);' . "\n";
        $html .= '      margin-bottom: 24px;' . "\n";
        $html .= '      padding-bottom: 10px;' . "\n";
        $html .= '      border-bottom: 2px solid #f1f5f9;' . "\n";
        $html .= '      position: relative;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .card-title::after {' . "\n";
        $html .= '      content: "";' . "\n";
        $html .= '      position: absolute;' . "\n";
        $html .= '      bottom: -2px;' . "\n";
        $html .= '      left: 0;' . "\n";
        $html .= '      width: 40px;' . "\n";
        $html .= '      height: 2px;' . "\n";
        $html .= '      background-color: var(--dh-orange);' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-list {' . "\n";
        $html .= '      list-style: none;' . "\n";
        $html .= '      display: flex;' . "\n";
        $html .= '      flex-direction: column;' . "\n";
        $html .= '      gap: 16px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-list-item {' . "\n";
        $html .= '      display: flex;' . "\n";
        $html .= '      align-items: flex-start;' . "\n";
        $html .= '      gap: 14px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-list-item i {' . "\n";
        $html .= '      color: var(--dh-orange);' . "\n";
        $html .= '      margin-top: 5px;' . "\n";
        $html .= '      font-size: 14px;' . "\n";
        $html .= '      flex-shrink: 0;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .link-group { display: flex; flex-direction: column; }' . "\n";
        $html .= '    .sitemap-link {' . "\n";
        $html .= '      color: var(--dh-dark);' . "\n";
        $html .= '      text-decoration: none;' . "\n";
        $html .= '      font-weight: 600;' . "\n";
        $html .= '      font-size: 15px;' . "\n";
        $html .= '      transition: color 0.2s ease;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-link:hover {' . "\n";
        $html .= '      color: var(--dh-orange);' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .link-desc {' . "\n";
        $html .= '      font-size: 13px;' . "\n";
        $html .= '      color: var(--dh-text-light);' . "\n";
        $html .= '      margin-top: 2px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .projects-column {' . "\n";
        $html .= '      display: flex;' . "\n";
        $html .= '      flex-direction: column;' . "\n";
        $html .= '      gap: 25px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .category-group {' . "\n";
        $html .= '      background: #ffffff;' . "\n";
        $html .= '      border: 1px solid var(--dh-border);' . "\n";
        $html .= '      border-radius: 12px;' . "\n";
        $html .= '      padding: 20px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .category-title {' . "\n";
        $html .= '      font-family: "Montserrat", sans-serif;' . "\n";
        $html .= '      font-size: 1.1rem;' . "\n";
        $html .= '      font-weight: 700;' . "\n";
        $html .= '      color: var(--dh-green);' . "\n";
        $html .= '      margin-bottom: 15px;' . "\n";
        $html .= '      display: flex;' . "\n";
        $html .= '      align-items: center;' . "\n";
        $html .= '      gap: 8px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .category-title i { font-size: 14px; }' . "\n";
        $html .= '    .project-links {' . "\n";
        $html .= '      list-style: none;' . "\n";
        $html .= '      display: grid;' . "\n";
        $html .= '      grid-template-columns: 1fr;' . "\n";
        $html .= '      gap: 12px;' . "\n";
        $html .= '      padding-left: 5px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .project-item {' . "\n";
        $html .= '      display: flex;' . "\n";
        $html .= '      align-items: center;' . "\n";
        $html .= '      gap: 8px;' . "\n";
        $html .= '      font-size: 14.5px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .project-item i {' . "\n";
        $html .= '      color: var(--dh-text-light);' . "\n";
        $html .= '      font-size: 8px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-footer {' . "\n";
        $html .= '      text-align: center;' . "\n";
        $html .= '      padding: 40px 20px;' . "\n";
        $html .= '      background-color: var(--dh-dark);' . "\n";
        $html .= '      color: #94a3b8;' . "\n";
        $html .= '      font-size: 13.5px;' . "\n";
        $html .= '      margin-top: 60px;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-footer a {' . "\n";
        $html .= '      color: #ffffff;' . "\n";
        $html .= '      text-decoration: none;' . "\n";
        $html .= '      font-weight: 600;' . "\n";
        $html .= '    }' . "\n";
        $html .= '    .sitemap-footer a:hover { color: var(--dh-orange); }' . "\n";
        $html .= '    @media (max-width: 991px) {' . "\n";
        $html .= '      .sitemap-grid {' . "\n";
        $html .= '        grid-template-columns: 1fr;' . "\n";
        $html .= '        gap: 30px;' . "\n";
        $html .= '      }' . "\n";
        $html .= '      .sitemap-header h1 {' . "\n";
        $html .= '        font-size: 2rem;' . "\n";
        $html .= '      }' . "\n";
        $html .= '    }' . "\n";
        $html .= '  </style>' . "\n";
        $html .= '</head>' . "\n";
        $html .= '<body>' . "\n";
        $html .= '  <header class="sitemap-header">' . "\n";
        $html .= '    <h1>KAVYA PROP</h1>' . "\n";
        $html .= '    <p>HTML Site Directory &amp; Navigation Portal. Find all listings and primary links within the Dholera Smart City projects portfolio.</p>' . "\n";
        $html .= '  </header>' . "\n";
        $html .= '  <main class="sitemap-container">' . "\n";
        $html .= '    <div class="sitemap-grid">' . "\n";
        
        // Left Column: Core Navigation
        $html .= '      <section class="sitemap-card">' . "\n";
        $html .= '        <h2 class="card-title">Core Directory</h2>' . "\n";
        $html .= '        <ul class="sitemap-list">' . "\n";
        foreach ($staticPages as $page) {
            $html .= '          <li class="sitemap-list-item">' . "\n";
            $html .= '            <i class="fa-solid fa-link"></i>' . "\n";
            $html .= '            <div class="link-group">' . "\n";
            $html .= '              <a class="sitemap-link" href="' . htmlspecialchars($page['file']) . '">' . htmlspecialchars($page['title']) . '</a>' . "\n";
            $html .= '              <span class="link-desc">' . $baseUrl . htmlspecialchars($page['loc']) . '</span>' . "\n";
            $html .= '            </div>' . "\n";
            $html .= '          </li>' . "\n";
        }
        $html .= '        </ul>' . "\n";
        $html .= '      </section>' . "\n";
        
        // Right Column: Projects listings
        $html .= '      <section class="projects-column">' . "\n";
        $html .= '        <div class="sitemap-card">' . "\n";
        $html .= '          <h2 class="card-title">Dholera Project Portfolio</h2>' . "\n";
        $html .= '          <div style="display: flex; flex-direction: column; gap: 20px;">' . "\n";
        
        if (empty($categorizedProjects)) {
            $html .= '            <p style="color: var(--dh-text-light);">No projects found in the directory database.</p>' . "\n";
        } else {
            foreach ($categorizedProjects as $category => $projList) {
                $html .= '            <div class="category-group">' . "\n";
                $html .= '              <h3 class="category-title"><i class="fa-solid fa-map-pin"></i> ' . htmlspecialchars($category) . '</h3>' . "\n";
                $html .= '              <ul class="project-links">' . "\n";
                foreach ($projList as $proj) {
                    $html .= '                <li class="project-item">' . "\n";
                    $html .= '                  <i class="fa-solid fa-circle"></i>' . "\n";
                    $html .= '                  <a class="sitemap-link" style="font-weight:500; font-size:14px;" href="project-details.php?id=' . $proj['id'] . '">' . htmlspecialchars($proj['title']) . '</a>' . "\n";
                    $html .= '                </li>' . "\n";
                }
                $html .= '              </ul>' . "\n";
                $html .= '            </div>' . "\n";
            }
        }
        
        $html .= '          </div>' . "\n";
        $html .= '        </div>' . "\n";
        $html .= '      </section>' . "\n";
        
        $html .= '    </div>' . "\n";
        $html .= '  </main>' . "\n";
        $html .= '  <footer class="sitemap-footer">' . "\n";
        $html .= '    <p>&copy; ' . date('Y') . ' <a href="index.php">Kavya Prop</a> - Dholera Smart City Infrastructure. All Rights Reserved.</p>' . "\n";
        $html .= '    <p style="margin-top:8px; font-size:11.5px; opacity:0.6;">XML Sitemap: <a style="color: #94a3b8; font-weight:normal;" href="sitemap.xml">sitemap.xml</a> | Generated automatically: ' . date('Y-m-d H:i:s') . '</p>' . "\n";
        $html .= '  </footer>' . "\n";
        $html .= '</body>' . "\n";
        $html .= '</html>' . "\n";

        // Write HTML sitemap to root
        @file_put_contents(__DIR__ . '/../sitemap.html', $html);
    }
}
