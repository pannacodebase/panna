
<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="UTF-8">
  

    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png" />
    <meta name="apple-mobile-web-app-title" content="CodePen">
    <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-2c7831bb44f98c1391d6a4ffda0e1fd302503391ca806e7fcc7b9b87197aec26.js"></script>
  <title>CodePen - Dashboard UI </title>

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  
  
<style>
@import url("https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");
:root {
  --c-text-primary: #282a32;
  --c-text-secondary: #686b87;
  --c-text-action: #404089;
  --c-accent-primary: #434ce8;
  --c-border-primary: #eff1f6;
  --c-background-primary: #ffffff;
  --c-background-secondary: #fdfcff;
  --c-background-tertiary: #ecf3fe;
  --c-background-quaternary: #e9ecf4;
}

body {
  line-height: 1.5;
  min-height: 100vh;
  font-family: "Be Vietnam Pro", sans-serif;
  background-color: var(--c-background-secondary);
  color: var(--c-text-primary);
}

img {
  display: block;
  max-width: 100%;
}

:focus {
  outline: 0;
}

.responsive-wrapper {
  width: 90%;
  margin: 0; /* Set margin to 0 */

  max-width: 1280px;
  margin-left: auto;
  margin-right: auto;
}

.header {
  display: flex;
  align-items: center;
  height: 80px;
  border-bottom: 1px solid var(--c-border-primary);
  background-color: var(--c-background-primary);
}

.header-content {
  display: flex;
  align-items: center;
}
.header-content > a {
  display: none;
}
@media (max-width: 1200px) {
  .header-content {
    justify-content: space-between;
  }
  .header-content > a {
    display: inline-flex;
  }
}

.header-logo {
  margin-right: 2.5rem;
}
.header-logo a {
  display: flex;
  align-items: center;
}
.header-logo a div {
  flex-shrink: 0;
  position: relative;
}
.header-logo a div:after {
  display: block;
  content: "";
  position: absolute;
  left: 0;
  top: auto;
  right: 0;
  bottom: 0;
  overflow: hidden;
  height: 50%;
  border-bottom-left-radius: 8px;
  border-bottom-right-radius: 8px;
  background-color: rgba(255, 255, 255, 0.2);
  -webkit-backdrop-filter: blur(4px);
          backdrop-filter: blur(4px);
}

.header-navigation {
  display: flex;
  flex-grow: 1;
  align-items: center;
  justify-content: space-between;
}
@media (max-width: 1200px) {
  .header-navigation {
    display: none;
  }
}

.header-navigation-links {
  display: flex;
  align-items: center;
}
.header-navigation-links a {
  text-decoration: none;
  color: var(--c-text-action);
  font-weight: 500;
  transition: 0.15s ease;
}
.header-navigation-links a + * {
  margin-left: 1.5rem;
}
.header-navigation-links a:hover, .header-navigation-links a:focus {
  color: var(--c-accent-primary);
}

.header-navigation-actions {
  display: flex;
  align-items: center;
}
.header-navigation-actions > .avatar {
  margin-left: 0.75rem;
}
.header-navigation-actions > .icon-button + .icon-button {
  margin-left: 0.25rem;
}
.header-navigation-actions > .button + .icon-button {
  margin-left: 1rem;
}

.button {
  font: inherit;
  color: inherit;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0 1em;
  height: 40px;
  border-radius: 8px;
  line-height: 1;
  border: 2px solid var(--c-border-primary);
  color: var(--c-text-action);
  font-size: 0.875rem;
  transition: 0.15s ease;
  background-color: var(--c-background-primary);
}
.button i {
  margin-right: 0.5rem;
  font-size: 1.25em;
}
.button span {
  font-weight: 500;
}
.button:hover, .button:focus {
  border-color: var(--c-accent-primary);
  color: var(--c-accent-primary);
}

.icon-button {
  font: inherit;
  color: inherit;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 8px;
  color: var(--c-text-action);
  transition: 0.15s ease;
}
.icon-button i {
  font-size: 1.25em;
}
.icon-button:focus, .icon-button:hover {
  background-color: var(--c-background-tertiary);
  color: var(--c-accent-primary);
}

.avatar {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 44px;
  height: 44px;
  border-radius: 50%;
  overflow: hidden;
}

.main {
  padding-top: 3rem;
}

.main-header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
}
.main-header h1 {
  font-size: 1.75rem;
  font-weight: 600;
  line-height: 1.25;
}
@media (max-width: 550px) {
  .main-header h1 {
    margin-bottom: 1rem;
  }
}

.search {
  position: relative;
  display: flex;
  align-items: center;
  width: 100%;
  max-width: 340px;
}
.search input {
  font: inherit;
  color: inherit;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0 1em 0 36px;
  height: 40px;
  border-radius: 8px;
  border: 2px solid var(--c-border-primary);
  color: var(--c-text-action);
  font-size: 0.875rem;
  transition: 0.15s ease;
  width: 100%;
  line-height: 1;
}
.search input::-moz-placeholder {
  color: var(--c-text-action);
}
.search input:-ms-input-placeholder {
  color: var(--c-text-action);
}
.search input::placeholder {
  color: var(--c-text-action);
}
.search input:focus, .search input:hover {
  border-color: var(--c-accent-primary);
}
.search button {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border: 0;
  background-color: transparent;
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 1.25em;
  color: var(--c-text-action);
  padding: 0;
  height: 40px;
}

.horizontal-tabs {
  margin-top: 1.5rem;
  display: flex;
  align-items: center;
  overflow-x: auto;
}
@media (max-width: 1000px) {
  .horizontal-tabs {
    scrollbar-width: none;
    position: relative;
  }
  .horizontal-tabs::-webkit-scrollbar {
    display: none;
  }
}
.horizontal-tabs a {
  display: inline-flex;
  flex-shrink: 0;
  align-items: center;
  height: 48px;
  padding: 0 0.25rem;
  font-weight: 500;
  color: inherit;
  border-bottom: 3px solid transparent;
  text-decoration: none;
  transition: 0.15s ease;
}
.horizontal-tabs a:hover, .horizontal-tabs a:focus, .horizontal-tabs a.active {
  color: var(--c-accent-primary);
  border-bottom-color: var(--c-accent-primary);
}
.horizontal-tabs a + * {
  margin-left: 1rem;
}

.content-header {
  display: flex;
  flex-wrap: wrap;
  align-items: center;
  justify-content: space-between;
  padding-top: 3rem;
  margin-top: -1px;
  border-top: 1px solid var(--c-border-primary);
}

.content-header-intro h2 {
  font-size: 1.25rem;
  font-weight: 600;
}
.content-header-intro p {
  color: var(--c-text-secondary);
  margin-top: 0.25rem;
  font-size: 0.875rem;
  margin-bottom: 1rem;
}

@media (min-width: 800px) {
  .content-header-actions a:first-child {
    display: none;
  }
}

.content {
      border-top: 1px solid var(--c-border-primary);
      margin-top: 2rem;
      display: flex;
      align-items: flex-start;
    }
    .content-panel {
      /* Updated style to make it static and frozen */
      position: sticky;
      top: 3rem;
      height: calc(100vh - 3rem);
      overflow-y: auto;
      max-width: 280px;
      width: 25%;
      padding: 2rem 1rem 2rem 0;
      margin-right: 3rem;
    }

@media (min-width: 800px) {
  .content-panel {
    display: block;
  }
}

.vertical-tabs {
  display: flex;
  flex-direction: column;
}
.vertical-tabs a {
  display: flex;
  align-items: center;
  padding: 0.75em 1em;
  background-color: transparent;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  color: var(--c-text-action);
  transition: 0.15s ease;
}
.vertical-tabs a:hover, .vertical-tabs a:focus, .vertical-tabs a.active {
  background-color: var(--c-background-tertiary);
  color: var(--c-accent-primary);
}
.vertical-tabs a + * {
  margin-top: 0.25rem;
}
.content-main {
      /* Updated style to make it scrollable */
      padding-top: 2rem;
      padding-bottom: 6rem;
      flex-grow: 1;
      overflow-y: auto;
      max-height: calc(100vh - 3rem);
    }

    /* Custom scrollbar style for .content-main */
    .content-main::-webkit-scrollbar {
      width: 8px;
    }

    .content-main::-webkit-scrollbar-thumb {
      background-color: #013289;
      border-radius: 2px;
    }

.card-grid {
  display: grid;
  grid-template-columns: repeat(1, 1fr);
  -moz-column-gap: 1.5rem;
       column-gap: 1.5rem;
  row-gap: 1.5rem;
}
@media (min-width: 600px) {
  .card-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}
@media (min-width: 1200px) {
  .card-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

.card {
  background-color: var(--c-background-primary);
  box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.05), 0 5px 15px 0 rgba(0, 0, 0, 0.05);
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.card-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  padding: 1.5rem 1.25rem 1rem 1.25rem;
}
.card-header div {
  display: flex;
  align-items: center;
}
.card-header div span {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}
.card-header div span img {
  max-height: 100%;
}
.card-header div h3 {
  margin-left: 0.75rem;
  font-weight: 500;
}

.toggle span {
  display: block;
  width: 40px;
  height: 24px;
  border-radius: 99em;
  background-color: var(--c-background-quaternary);
  box-shadow: inset 1px 1px 1px 0 rgba(0, 0, 0, 0.05);
  position: relative;
  transition: 0.15s ease;
}
.toggle span:before {
  content: "";
  display: block;
  position: absolute;
  left: 3px;
  top: 3px;
  height: 18px;
  width: 18px;
  background-color: var(--c-background-primary);
  border-radius: 50%;
  box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.15);
  transition: 0.15s ease;
}
.toggle input {
  clip: rect(0 0 0 0);
  -webkit-clip-path: inset(50%);
          clip-path: inset(50%);
  height: 1px;
  overflow: hidden;
  position: absolute;
  white-space: nowrap;
  width: 1px;
}
.toggle input:checked + span {
  background-color: var(--c-accent-primary);
}
.toggle input:checked + span:before {
  transform: translateX(calc(100% - 2px));
}
.toggle input:focus + span {
  box-shadow: 0 0 0 4px var(--c-background-tertiary);
}

.card-body {
  padding: 1rem 1.25rem;
  font-size: 0.875rem;
}

.card-footer {
  margin-top: auto;
  padding: 1rem 1.25rem;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  border-top: 1px solid var(--c-border-primary);
}
.card-footer a {
  color: var(--c-text-action);
  text-decoration: none;
  font-weight: 500;
  font-size: 0.875rem;
}

html::-webkit-scrollbar {
  width: 12px;
}
html::-webkit-scrollbar-thumb {
  background-color: var(--c-text-primary);
  border: 4px solid var(--c-background-primary);
  border-radius: 99em;
}
</style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
</head>


<main class="main">
	<div class="responsive-wrapper">
		<div class="content-header">
			<div class="content-header-intro">
				<h2>Intergrations and connected apps</h2>
				
			</div>
			<div class="content-header-actions">
				<a href="#" class="button">
					<i class="ph-faders-bold"></i>
					<span>Filters</span>
				</a>
				<a href="#" class="button">
					<i class="ph-plus-bold"></i>
					<span>Request integration</span>
				</a>
			</div>
		</div>
		<div class="content">
			<div class="content-panel">
				<div class="vertical-tabs">
					<a href="#" class="active">View all</a>
					<a href="#">Behaviour and Sensory</a>
					<a href="#">Speech & Language</a>
					<a href="#">Special Education</a>
					<a href="#">Social Interactions</a>
                    <a href="#">Academic Achievement</a>
                    <a href="#">Anxiety and Emotional Regulation</a>
                    <a href="#">Indepdence and Daily Living</a>
					<a href="#">Health and Well Being</a>
				</div>
			</div>
			<div class="content-main">
				<div class="card-grid">
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/zeplin.svg" /></span>
								<h3>Zeplin</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Collaboration between designers and developers.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/github.svg" /></span>
								<h3>GitHub</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Link pull requests and automate workflows.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/figma.svg" /></span>
								<h3>Figma</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Embed file previews in projects.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/zapier.svg" /></span>
								<h3>Zapier</h3>
							</div>
							<label class="toggle">
								<input type="checkbox">
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Build custom automations and integrations with apps.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/notion.svg" /></span>
								<h3>Notion</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Embed notion pages and notes in projects.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/slack.svg" /></span>
								<h3>Slack</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Send notifications to channels and create projects.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/zendesk.svg" /></span>
								<h3>Zendesk</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Link and automate Zendesk tickets.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/jira.svg" /></span>
								<h3>Atlassian JIRA</h3>
							</div>
							<label class="toggle">
								<input type="checkbox">
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Plan, track, and release great software.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/dropbox.svg" /></span>
								<h3>Dropbox</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Everything you need for work, all in one place.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/google-chrome.svg" /></span>
								<h3>Google Chrome</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Link your Google account to share bookmarks across your entire team.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/discord.svg" /></span>
								<h3>Discord</h3>
							</div>
							<label class="toggle">
								<input type="checkbox" checked>
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Keep in touch with your customers without leaving the app.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
					<article class="card">
						<div class="card-header">
							<div>
								<span><img src="https://assets.codepen.io/285131/google-drive.svg" /></span>
								<h3>Google Drive</h3>
							</div>
							<label class="toggle">
								<input type="checkbox">
								<span></span>
							</label>
						</div>
						<div class="card-body">
							<p>Link your Google account to share files across your entire team.</p>
						</div>
						<div class="card-footer">
							<a href="#">View integration</a>
						</div>
					</article>
				</div>
			</div>
		</div>
	</div>
</main>
  <script src='https://unpkg.com/phosphor-icons'></script>
      <script id="rendered-js" >
// Nope. This is a concept design, so no menu or filter toggles work. But it looks good, doesn't it?
//# sourceURL=pen.js
    </script>

  
</body>

</html>
