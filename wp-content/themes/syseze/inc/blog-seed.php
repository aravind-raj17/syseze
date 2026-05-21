<?php
/**
 * Seed the three starter blog posts on first WordPress load.
 * Uses an option flag so it only ever runs once.
 *
 * @package SysEze
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* ─── disable wpautop for our structured HTML posts ─── */
add_action( 'the_post', function ( $post ) {
	if ( 'post' === get_post_type( $post ) && get_post_meta( $post->ID, '_syseze_cover_url', true ) ) {
		remove_filter( 'the_content', 'wpautop' );
	}
} );

/* ─── seeder ─── */
function syseze_seed_blog_posts() {
	if ( get_option( 'syseze_blog_seeded_v1' ) ) {
		return;
	}

	/* ══ POST 1 ══════════════════════════════════════════════════════ */
	$post1_content = <<<'HTML'
<style>
.uplink-post{font-family:Georgia,serif;color:#1a1714;max-width:760px;margin:0 auto;line-height:1.65;font-size:18px;}
.uplink-post .uplink-meta{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;font-weight:600;margin-bottom:16px;}
.uplink-post .uplink-meta .tag{color:#b8451e;}
.uplink-post .uplink-dek{font-size:22px;line-height:1.4;color:#3d3631;font-style:italic;margin:0 0 28px;}
.uplink-post figure.uplink-hero{margin:0 0 36px;}
.uplink-post figure.uplink-hero img{width:100%;height:auto;display:block;}
.uplink-post figure.uplink-hero figcaption{font-size:14px;color:#7a6f63;font-style:italic;text-align:center;margin-top:10px;}
.uplink-post h2{font-family:Georgia,serif;font-weight:400;font-size:32px;line-height:1.1;margin:2em 0 .5em;letter-spacing:-.02em;}
.uplink-post h2 em{color:#b8451e;font-style:italic;}
.uplink-post h3{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:#7a6f63;margin:2em 0 .4em;font-weight:600;}
.uplink-post p{margin:0 0 1.2em;}
.uplink-post ul{padding-left:1.4em;margin:1.2em 0;}
.uplink-post ul li{margin-bottom:.5em;}
.uplink-post ul li::marker{color:#b8451e;}
.uplink-post blockquote.uplink-pq{margin:2em 0;padding:0 0 0 24px;border-left:3px solid #b8451e;font-family:Georgia,serif;font-style:italic;font-size:26px;line-height:1.25;color:#1a1714;}
.uplink-post blockquote.uplink-pq footer{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-style:normal;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;margin-top:14px;font-weight:600;}
.uplink-post aside.uplink-callout{background:#faf6ee;border:1px solid rgba(0,0,0,.08);border-left:3px solid #b8451e;padding:24px 28px;margin:2em 0;}
.uplink-post aside.uplink-callout h4{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#b8451e;margin:0 0 12px;font-weight:700;}
.uplink-post aside.uplink-callout ul{margin:0;padding-left:1.2em;}
.uplink-post aside.uplink-callout li{font-size:16px;margin-bottom:8px;}
.uplink-post .uplink-stats{display:flex;gap:0;border-top:1px solid rgba(0,0,0,.14);border-bottom:1px solid rgba(0,0,0,.14);padding:24px 0;margin:2.4em 0;text-align:center;}
.uplink-post .uplink-stats .stat{flex:1;padding:0 12px;border-right:1px solid rgba(0,0,0,.08);}
.uplink-post .uplink-stats .stat:last-child{border-right:none;}
.uplink-post .uplink-stats .num{font-family:Georgia,serif;font-size:48px;line-height:1;color:#b8451e;letter-spacing:-.02em;}
.uplink-post .uplink-stats .label{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;margin-top:8px;font-weight:600;}
.uplink-post .uplink-byline{display:flex;align-items:center;gap:12px;margin:32px 0 0;padding-top:24px;border-top:1px solid rgba(0,0,0,.08);font-size:14px;color:#7a6f63;}
.uplink-post .uplink-byline .name{color:#1a1714;font-weight:600;}
@media (max-width:600px){.uplink-post .uplink-stats{flex-direction:column;gap:18px;}.uplink-post .uplink-stats .stat{border-right:none;border-bottom:1px solid rgba(0,0,0,.08);padding-bottom:18px;}.uplink-post .uplink-stats .stat:last-child{border-bottom:none;padding-bottom:0;}}
</style>
<article class="uplink-post">
  <div class="uplink-meta"><span class="tag">Security</span> · 9 min read · May 14, 2026</div>
  <p class="uplink-dek">We spent eighteen months and seven figures buying the architecture. The thing that actually moved our blast radius was three habits nobody sold us.</p>
  <figure class="uplink-hero">
    <img src="https://images.unsplash.com/photo-1614064641938-3bbee52942c7?w=1600&q=80" alt="Zero Trust isn't a product. It's a posture." />
    <figcaption>A managed services rack at 03:00 — the hour most posture failures are first observed.</figcaption>
  </figure>
  <p>The pitch deck arrived on a Tuesday. Forty-seven slides. Three vendors in the room. By slide nine I knew we were going to sign something, and by slide twenty I knew the something would not, on its own, make us safer. That was eighteen months ago. The contracts are signed, the agents are deployed, the dashboards are green, and our actual blast radius — the part the auditor never asks about — only started shrinking when we stopped treating Zero Trust as a procurement project.</p>
<p>I want to write down what changed, because I keep having the same conversation with peers who are six months into the same journey, asking the same question: why doesn't it feel different yet?</p>
<h2>The <em>first mistake</em> was buying the architecture before the habit.</h2>
<p>Zero Trust, as a phrase, is a marketing accident. The principle underneath it — never trust, always verify, assume breach — is a posture. Postures are not delivered by a vendor. They show up in how engineers behave when they're tired, on call, and trying to ship.</p>
<p>Our first six months were spent rolling out an identity-aware proxy, a SASE tier, microsegmentation in two of our four clusters, and a privileged-access broker. All of it real, all of it useful, none of it changing what an engineer did at 2 a.m. when production was on fire. They opened a long-lived bastion, sudo'd to root, and fixed the thing. The proxy was just another login screen on the way to the same all-powerful shell.</p>
<blockquote class="uplink-pq">If your incident playbook still ends in a root shell on a long-lived host, you don't have Zero Trust. You have an expensive front door.<footer>— From the post-mortem of our March outage</footer></blockquote>
<h2>What actually moved the needle</h2>
<p>Three habits, in the order we adopted them. None of them required a new SKU.</p>
<h3>1. Default to ephemeral</h3>
<p>No persistent SSH keys. No long-lived service accounts. Every human session, every CI worker, every cron job authenticates fresh and dies. The credential cannot outlive the task. This is boring to implement and existentially uncomfortable to operate — for the first month, every on-call engineer hated me personally — but it removes an entire class of breach. There is nothing to steal that is still valid by the time it is stolen.</p>
<h3>2. Make the audit trail the source of truth</h3>
<p>Logs are not for forensics; they are the system of record. If a change was made and the audit log doesn't show who, what, when, and why, the change did not happen and must be reverted. We pushed this all the way to read operations on tier-zero data. It is annoying. It has saved us at least one incident I can point to and probably two I cannot.</p>
<h3>3. Treat the network as hostile, including the office one</h3>
<p>The VPN died on a Friday and was not mourned. Our office wifi has the same trust posture as a hotel lobby. Every connection to every internal service goes through the same identity-aware path whether you are sitting at headquarters or at a kitchen table in Lisbon. This is the only one of the three that required actual product spend — but the spend was a tenth of what we'd already committed, and the operational simplification paid for it in a quarter.</p>
<aside class="uplink-callout"><h4>The cheap version of all three</h4><ul><li>Rotate every static credential you own. Set the rotation interval to days, not quarters. The pain you feel is the signal of the problem.</li><li>Stand up centralized audit logging before you stand up centralized identity. You will regret the reverse.</li><li>Pick one production system. Make accessing it from the corporate network indistinguishable from accessing it from Starbucks. Notice what breaks. Fix that.</li></ul></aside>
<h2>What I'd do differently</h2>
<p>I'd sequence the habits before the architecture. Spend the first quarter on credential lifecycle and audit-log discipline. Force every team to feel the friction of doing the right thing manually. Then — and only then — buy the tooling that smooths the friction, because by that point your engineers will know exactly which friction to smooth and which to keep.</p>
<p>The vendors will tell you their platform is Zero Trust. It is not. It is a substrate on which Zero Trust can be practiced by people who already wanted to practice it. The platform without the practice is a CAPEX line item with a dashboard. The practice without the platform is exhausting but real. With both, you have something worth the budget.</p>
<p>The auditor still doesn't ask about blast radius. But the last time we had a credential exposed in a public repo, the credential was four hours old, scoped to one read, and had been rotated out before the bot that scraped GitHub finished indexing the commit. That's the posture. The architecture just helped us scale it.</p>
</article>
HTML;

	/* ══ POST 2 ══════════════════════════════════════════════════════ */
	$post2_content = <<<'HTML'
<style>
.uplink-post{font-family:Georgia,serif;color:#1a1714;max-width:760px;margin:0 auto;line-height:1.65;font-size:18px;}
.uplink-post .uplink-meta{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;font-weight:600;margin-bottom:16px;}
.uplink-post .uplink-meta .tag{color:#b8451e;}
.uplink-post .uplink-dek{font-size:22px;line-height:1.4;color:#3d3631;font-style:italic;margin:0 0 28px;}
.uplink-post figure.uplink-hero{margin:0 0 36px;}
.uplink-post figure.uplink-hero img{width:100%;height:auto;display:block;}
.uplink-post figure.uplink-hero figcaption{font-size:14px;color:#7a6f63;font-style:italic;text-align:center;margin-top:10px;}
.uplink-post h2{font-family:Georgia,serif;font-weight:400;font-size:32px;line-height:1.1;margin:2em 0 .5em;letter-spacing:-.02em;}
.uplink-post h2 em{color:#b8451e;font-style:italic;}
.uplink-post h3{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:#7a6f63;margin:2em 0 .4em;font-weight:600;}
.uplink-post p{margin:0 0 1.2em;}
.uplink-post ul{padding-left:1.4em;margin:1.2em 0;}
.uplink-post ul li{margin-bottom:.5em;}
.uplink-post ul li::marker{color:#b8451e;}
.uplink-post blockquote.uplink-pq{margin:2em 0;padding:0 0 0 24px;border-left:3px solid #b8451e;font-family:Georgia,serif;font-style:italic;font-size:26px;line-height:1.25;color:#1a1714;}
.uplink-post blockquote.uplink-pq footer{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-style:normal;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;margin-top:14px;font-weight:600;}
.uplink-post aside.uplink-callout{background:#faf6ee;border:1px solid rgba(0,0,0,.08);border-left:3px solid #b8451e;padding:24px 28px;margin:2em 0;}
.uplink-post aside.uplink-callout h4{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#b8451e;margin:0 0 12px;font-weight:700;}
.uplink-post aside.uplink-callout ul{margin:0;padding-left:1.2em;}
.uplink-post aside.uplink-callout li{font-size:16px;margin-bottom:8px;}
.uplink-post .uplink-stats{display:flex;gap:0;border-top:1px solid rgba(0,0,0,.14);border-bottom:1px solid rgba(0,0,0,.14);padding:24px 0;margin:2.4em 0;text-align:center;}
.uplink-post .uplink-stats .stat{flex:1;padding:0 12px;border-right:1px solid rgba(0,0,0,.08);}
.uplink-post .uplink-stats .stat:last-child{border-right:none;}
.uplink-post .uplink-stats .num{font-family:Georgia,serif;font-size:48px;line-height:1;color:#b8451e;letter-spacing:-.02em;}
.uplink-post .uplink-stats .label{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;margin-top:8px;font-weight:600;}
.uplink-post .uplink-byline{display:flex;align-items:center;gap:12px;margin:32px 0 0;padding-top:24px;border-top:1px solid rgba(0,0,0,.08);font-size:14px;color:#7a6f63;}
.uplink-post .uplink-byline .name{color:#1a1714;font-weight:600;}
@media (max-width:600px){.uplink-post .uplink-stats{flex-direction:column;gap:18px;}.uplink-post .uplink-stats .stat{border-right:none;border-bottom:1px solid rgba(0,0,0,.08);padding-bottom:18px;}.uplink-post .uplink-stats .stat:last-child{border-bottom:none;padding-bottom:0;}}
</style>
<article class="uplink-post">
  <div class="uplink-meta"><span class="tag">Cloud Migration</span> · 11 min read · April 28, 2026</div>
  <p class="uplink-dek">A regulator gave us a deadline. We gave ourselves three rules. Here is what survived contact with reality, what didn't, and the one decision that mattered more than every tool we picked combined.</p>
  <figure class="uplink-hero">
    <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1600&q=80" alt="What we learned migrating 12,000 VMs in 90 days." />
    <figcaption>Wave three, day forty-one. The diagram on the wall had been rewritten four times that week.</figcaption>
  </figure>
  <p>On a Friday in late January, our regulator notified us — with the formal politeness regulators reserve for moments of maximum unhelpfulness — that one of our data center contracts was no longer compliant with new sovereignty rules, and would not be renewed. We had until the end of April to be out. Approximately twelve thousand virtual machines, four hundred terabytes of relational data, and a tangle of seventeen years of decisions made by people who no longer worked here. Ninety days.</p>
<p>We made it. Two went down for longer than we wanted. None lost data. The retrospective took six weeks and produced a document longer than this article. What follows is the shortest version I can write while still being honest.</p>
<h2>The wave structure</h2>
<p>We organized everything into five waves. Wave zero was discovery: every running process, every dependency, every certificate, every hard-coded IP. Waves one through four were the actual migration, sequenced by blast radius — the things that could fail loudly without taking the company down went first, the things that could not fail at all went last. Each wave was two weeks. Each wave ended with a real cut-over of real production. There was no "pilot" wave that didn't count. Every wave counted.</p>
<div class="uplink-stats"><div class="stat"><div class="num">12,184</div><div class="label">VMs migrated</div></div><div class="stat"><div class="num">90</div><div class="label">Days, including the regulator's grace period</div></div><div class="stat"><div class="num">2</div><div class="label">Production incidents over 30 minutes</div></div></div>
<h2>The three rules</h2>
<p>Before wave one started, we wrote three rules on a whiteboard. They stayed up for ninety days. Every architectural argument got resolved by checking which rule applied. I cannot overstate how much time this saved.</p>
<h3>Rule 1 — Lift, then shift, then improve. Never simultaneously.</h3>
<p>The temptation to "fix this while we're touching it" is the single biggest reason migrations slip. We had a long list of things we wanted to clean up — services that should be containerized, databases that should be sharded, scheduled jobs that should be event-driven — and we deferred all of them. Every one. The migration's job was to move the workload to the new substrate without changing its shape. Improvement comes after stability, not during transition.</p>
<h3>Rule 2 — If you can't roll it back in an hour, you can't roll it forward today.</h3>
<p>Every cut-over had a documented rollback path tested before the cut-over happened. If a rollback would take more than an hour, the cut-over didn't happen that day. This sounds slow. It was faster. We rolled back twice in ninety days, both times to a clean known-good state, both times without an all-hands incident. The rollback discipline is the only reason the team could move quickly without being terrified.</p>
<h3>Rule 3 — The owner of the workload owns the cut-over.</h3>
<p>Platform team did not migrate anyone's service. We migrated the substrate. The teams who owned each workload did the cut-over themselves, on our tooling, with our support. This was unpopular for the first two weeks and indispensable by week three. Nobody knows the strange behavior of a system better than the people who built and ran it. Centralizing the cut-over decision in the platform team would have created a bottleneck and, worse, an accountability gap when something went sideways.</p>
<blockquote class="uplink-pq">Migrations don't fail because the new system is wrong. They fail because the people who know the old system are not the ones doing the cut-over.<footer>— Wave four retrospective</footer></blockquote>
<h2>What broke anyway</h2>
<p>Two outages, both during wave three, both caused by the same thing: a hard-coded IP address in a configuration file that was managed by a different team than the one running the cut-over. The first time it happened we lost forty-six minutes of write availability on a non-critical service. The second time we lost twenty-one minutes, on a more critical service, but we knew what to look for and the rollback was clean.</p>
<p>Both came down to the same gap: our discovery tooling was good at finding network dependencies between hosts, and bad at finding configuration that named hosts by IP rather than DNS. Between waves one and two we added a static-analysis pass that grepped every config repo for IP-shaped strings. We thought we'd caught them all. We had caught maybe 80%. The other 20% were in places like the body of an alerting webhook or a comment-out-but-still-active block in a Puppet manifest that had been forgotten for nine years.</p>
<aside class="uplink-callout"><h4>Things our discovery tooling missed</h4><ul><li>Hard-coded IPs in commented-out configuration blocks that were, in fact, still active.</li><li>Cron jobs running from a user's home directory on a host nobody knew was a host. (It was a workstation under a desk.)</li><li>A single DNS entry pointing to a service that had been moved three years prior but never repointed.</li><li>Two SSL certificates pinned by fingerprint inside a mobile client we'd shipped to 40,000 employees.</li></ul></aside>
<h2>The one decision that mattered more than the rest</h2>
<p>Before wave zero, we spent ten days arguing about tooling. Cloud A or cloud B; this migration platform or that one; rehost or replatform. The argument felt important. It was not. Every option on the shortlist would have worked. None of them would have failed catastrophically. The decisions inside the wave structure — which order, which rollback, which owner — mattered far more than the substrate decisions we agonized over.</p>
<p>If I could give my January self one piece of advice, it would be: pick the cloud you have the most operational experience with, even if the other one is technically better on paper. Familiarity is a multiplier on every other decision you make for ninety straight days. We picked the one we knew. I am certain that was right.</p>
<h2>After</h2>
<p>Wave four cut over on April 23rd. The last machine in the old data center was decommissioned on April 28th, two days before the deadline. The team took the long weekend off, which was the first long weekend any of us had taken since January. The improvement work — the deferred containerization, the sharding, the event-driven cleanups — started in earnest in May and will run for most of this year. We are doing it slowly, with proper design reviews, with no regulator in the room. It is much more pleasant work.</p>
<p>The migration was the hardest thing this team has done together. It is also, by a comfortable margin, the most proud I have ever been of a group of engineers. Ninety days. Three rules. One whiteboard. The substrate matters less than people will tell you. The discipline matters more.</p>
</article>
HTML;

	/* ══ POST 3 ══════════════════════════════════════════════════════ */
	$post3_content = <<<'HTML'
<style>
.uplink-post{font-family:Georgia,serif;color:#1a1714;max-width:760px;margin:0 auto;line-height:1.65;font-size:18px;}
.uplink-post .uplink-meta{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;font-weight:600;margin-bottom:16px;}
.uplink-post .uplink-meta .tag{color:#b8451e;}
.uplink-post .uplink-dek{font-size:22px;line-height:1.4;color:#3d3631;font-style:italic;margin:0 0 28px;}
.uplink-post figure.uplink-hero{margin:0 0 36px;}
.uplink-post figure.uplink-hero img{width:100%;height:auto;display:block;}
.uplink-post figure.uplink-hero figcaption{font-size:14px;color:#7a6f63;font-style:italic;text-align:center;margin-top:10px;}
.uplink-post h2{font-family:Georgia,serif;font-weight:400;font-size:32px;line-height:1.1;margin:2em 0 .5em;letter-spacing:-.02em;}
.uplink-post h2 em{color:#b8451e;font-style:italic;}
.uplink-post h3{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:#7a6f63;margin:2em 0 .4em;font-weight:600;}
.uplink-post p{margin:0 0 1.2em;}
.uplink-post ul{padding-left:1.4em;margin:1.2em 0;}
.uplink-post ul li{margin-bottom:.5em;}
.uplink-post ul li::marker{color:#b8451e;}
.uplink-post blockquote.uplink-pq{margin:2em 0;padding:0 0 0 24px;border-left:3px solid #b8451e;font-family:Georgia,serif;font-style:italic;font-size:26px;line-height:1.25;color:#1a1714;}
.uplink-post blockquote.uplink-pq footer{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-style:normal;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;margin-top:14px;font-weight:600;}
.uplink-post aside.uplink-callout{background:#faf6ee;border:1px solid rgba(0,0,0,.08);border-left:3px solid #b8451e;padding:24px 28px;margin:2em 0;}
.uplink-post aside.uplink-callout h4{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#b8451e;margin:0 0 12px;font-weight:700;}
.uplink-post aside.uplink-callout ul{margin:0;padding-left:1.2em;}
.uplink-post aside.uplink-callout li{font-size:16px;margin-bottom:8px;}
.uplink-post .uplink-stats{display:flex;gap:0;border-top:1px solid rgba(0,0,0,.14);border-bottom:1px solid rgba(0,0,0,.14);padding:24px 0;margin:2.4em 0;text-align:center;}
.uplink-post .uplink-stats .stat{flex:1;padding:0 12px;border-right:1px solid rgba(0,0,0,.08);}
.uplink-post .uplink-stats .stat:last-child{border-right:none;}
.uplink-post .uplink-stats .num{font-family:Georgia,serif;font-size:48px;line-height:1;color:#b8451e;letter-spacing:-.02em;}
.uplink-post .uplink-stats .label{font-family:-apple-system,BlinkMacSystemFont,sans-serif;font-size:11px;letter-spacing:.14em;text-transform:uppercase;color:#7a6f63;margin-top:8px;font-weight:600;}
.uplink-post .uplink-byline{display:flex;align-items:center;gap:12px;margin:32px 0 0;padding-top:24px;border-top:1px solid rgba(0,0,0,.08);font-size:14px;color:#7a6f63;}
.uplink-post .uplink-byline .name{color:#1a1714;font-weight:600;}
@media (max-width:600px){.uplink-post .uplink-stats{flex-direction:column;gap:18px;}.uplink-post .uplink-stats .stat{border-right:none;border-bottom:1px solid rgba(0,0,0,.08);padding-bottom:18px;}.uplink-post .uplink-stats .stat:last-child{border-bottom:none;padding-bottom:0;}}
</style>
<article class="uplink-post">
  <div class="uplink-meta"><span class="tag">Automation</span> · 7 min read · May 7, 2026</div>
  <p class="uplink-dek">We pointed an LLM at our ticketing system expecting a chatbot. We got something stranger: a tier-one analyst that never sleeps, never escalates the wrong thing, and finally let our humans do interesting work.</p>
  <figure class="uplink-hero">
    <img src="https://images.unsplash.com/photo-1531746790731-6c087fecd65a?w=1600&q=80" alt="The helpdesk that closes its own tickets." />
    <figcaption>The team's new daily standup spends more time discussing what the agent shouldn't do than what it should.</figcaption>
  </figure>
  <p>On a Tuesday in January, a junior accountant named Renee filed ticket #44912: "Outlook keeps asking for my password." By the time the human on shift opened the queue at 8:47 a.m., the ticket was closed. The resolution note said the user's MFA token had drifted, a fresh one had been issued, the offending cached credential had been cleared from her keychain, and she had been emailed a two-line explanation with a screenshot. Renee had already replied: thanks.</p>
<p>Our humans had not touched it. None of us realized for about forty minutes.</p>
<h2>The before</h2>
<p>Our IT desk was eight people supporting fourteen hundred. The queue had a steady-state size of roughly two hundred open tickets and a long tail of three- and four-day-olds that nobody loved. Median time-to-first-response was thirty-eight minutes during the day and four hours overnight. About 70% of inbound was, by volume, the same nine problems — password resets, MFA drift, VPN config, printer queues, Slack permissions, license assignments, calendar sync, the eternal Outlook profile rebuild, and a remarkable number of "my microphone doesn't work" tickets that turned out, every time, to be the operating system's privacy toggle.</p>
<div class="uplink-stats"><div class="stat"><div class="num">63%</div><div class="label">Tickets now closed without human touch</div></div><div class="stat"><div class="num">9 min</div><div class="label">Median time-to-resolution, all tickets</div></div><div class="stat"><div class="num">0</div><div class="label">Layoffs from automation</div></div></div>
<h2>What we actually built</h2>
<p>Not a chatbot. The thing that has worked, surprisingly well, is an agent that reads incoming tickets, decides whether it can resolve them, and either resolves them end-to-end or hands them to a human with a structured summary and its best guess. The difference is small in description and enormous in practice.</p>
<p>When a ticket comes in, the agent does roughly this:</p>
<ul><li>Reads the ticket and any prior history from the same user.</li><li>Checks the user's current state against the obvious telemetry sources — identity provider, MDM, the relevant SaaS audit logs.</li><li>Forms a hypothesis. Writes the hypothesis down, in plain English, in a hidden field on the ticket.</li><li>If the hypothesis matches a class of problem we've explicitly authorized it to fix, it runs the fix and tells the user what it did.</li><li>If not, it leaves the hypothesis and a recommended next step on the ticket and routes it to a human.</li></ul>
<blockquote class="uplink-pq">The agent's job isn't to be right. It's to make the human's first thirty seconds on the ticket count.<footer>— From our internal runbook</footer></blockquote>
<p>That last point is the part nobody talks about, and it has done as much for our team morale as the automation itself. When a human picks up a ticket now, they don't start from a one-line user complaint. They start from: "User reports Outlook prompting for password. Last successful auth was 14 hours ago. MFA token last rotated 19 days ago, which is unusual; the user's cohort rotates every 7. Recommended action: force token rotation, expect resolution. Did not auto-resolve because user has elevated mailbox delegation and our policy requires human confirmation for credential changes on delegated accounts." The human can confirm or reject in fifteen seconds. They spend the rest of the hour on the genuinely strange tickets.</p>
<h2>What we won't let it touch</h2>
<p>We were strict about the kill switches from day one. None of these are technical limitations — the agent could do all of them — but we decided they belonged to humans and we have not regretted that decision.</p>
<aside class="uplink-callout"><h4>The agent's deny-list</h4><ul><li>Anything that modifies access for an executive or their delegates.</li><li>Anything involving customer data, even read-only.</li><li>Anything that creates, deletes, or modifies a license seat. (Procurement-adjacent.)</li><li>Anything where the user has filed more than two tickets in the same week — that's a human's job to notice the pattern.</li><li>Anything tagged 'urgent' by the user. The agent triages and summarizes; a human decides.</li></ul></aside>
<p>The deny-list is longer than we expected to need. It is also the only reason senior leadership signed off on letting the agent take action at all. Every quarter we review the list and, in practice, we have added items more often than we have removed them. The agent's footprint expands by removing entries from a deny-list, not by adding entries to an allow-list. This sounds like the same thing. It is not.</p>
<h2>The team</h2>
<p>The thing I was most worried about — that the humans would feel demoted, or replaceable, or bored — has not happened. The work that is left is interesting in a way the work before was not. We have built two internal tools in the last quarter that we would never have had time to build before. One of them, an onboarding orchestrator for new hires, has already saved more time than the agent does. The agent gave the team time to be the kind of IT shop they always said they wanted to be: one that builds things, not one that resets passwords.</p>
<p>Renee, for what it's worth, no longer files tickets about Outlook. She did file one last week about a strange networking issue at a co-working space in Berlin. The agent took one look and routed it to a human with the note: "Out of scope. Recommend a human conversation; user's location and corporate VPN policy interact in ways I am not confident about." That ticket took us a real forty minutes to resolve. It was a good forty minutes.</p>
</article>
HTML;

	/* ══ build post list ══════════════════════════════════════════════ */
	$posts = [
		[
			'title'    => "Zero Trust isn't a product. It's a posture.",
			'slug'     => 'zero-trust-isnt-a-product',
			'excerpt'  => 'We spent eighteen months and seven figures buying the architecture. The thing that actually moved our blast radius was three habits nobody sold us.',
			'date'     => '2026-05-14 09:00:00',
			'cat_name' => 'Security',
			'cat_slug' => 'security',
			'cover'    => 'https://images.unsplash.com/photo-1614064641938-3bbee52942c7?w=1200&q=80',
			'content'  => $post1_content,
		],
		[
			'title'    => 'What we learned migrating 12,000 VMs in 90 days.',
			'slug'     => 'migrating-12000-vms-in-90-days',
			'excerpt'  => 'A regulator gave us a deadline. We gave ourselves three rules. Here is what survived contact with reality, and the one decision that mattered more than every tool we picked combined.',
			'date'     => '2026-04-28 09:00:00',
			'cat_name' => 'Cloud Migration',
			'cat_slug' => 'cloud-migration',
			'cover'    => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200&q=80',
			'content'  => $post2_content,
		],
		[
			'title'    => 'The helpdesk that closes its own tickets.',
			'slug'     => 'helpdesk-that-closes-its-own-tickets',
			'excerpt'  => 'We pointed an LLM at our ticketing system expecting a chatbot. We got something stranger: a tier-one analyst that never sleeps and finally let our humans do interesting work.',
			'date'     => '2026-05-07 09:00:00',
			'cat_name' => 'Automation',
			'cat_slug' => 'automation',
			'cover'    => 'https://images.unsplash.com/photo-1531746790731-6c087fecd65a?w=1200&q=80',
			'content'  => $post3_content,
		],
	];

	foreach ( $posts as $pd ) {
		if ( get_page_by_path( $pd['slug'], OBJECT, 'post' ) ) {
			continue;
		}

		$cat = get_term_by( 'slug', $pd['cat_slug'], 'category' );
		if ( ! $cat ) {
			$ins    = wp_insert_term( $pd['cat_name'], 'category', [ 'slug' => $pd['cat_slug'] ] );
			$cat_id = is_wp_error( $ins ) ? 0 : (int) $ins['term_id'];
		} else {
			$cat_id = (int) $cat->term_id;
		}

		$args = [
			'post_title'    => $pd['title'],
			'post_name'     => $pd['slug'],
			'post_excerpt'  => $pd['excerpt'],
			'post_content'  => $pd['content'],
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_date'     => $pd['date'],
			'meta_input'    => [ '_syseze_cover_url' => $pd['cover'] ],
		];
		if ( $cat_id ) {
			$args['post_category'] = [ $cat_id ];
		}

		wp_insert_post( $args );
	}

	update_option( 'syseze_blog_seeded_v1', '1' );
}
add_action( 'init', 'syseze_seed_blog_posts', 99 );

/* ─── one-time update: point cover meta to local theme images ─── */
function syseze_update_blog_covers() {
	if ( get_option( 'syseze_blog_covers_local_v1' ) ) {
		return;
	}

	$map = [
		'zero-trust-isnt-a-product'            => 'zero-trust-isnt-a-product.jpg',
		'migrating-12000-vms-in-90-days'       => 'migrating-12000-vms-in-90-days.jpg',
		'helpdesk-that-closes-its-own-tickets' => 'helpdesk-that-closes-its-own-tickets.jpg',
	];

	$base = get_template_directory_uri() . '/assets/images/blog/';

	foreach ( $map as $slug => $file ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( $post ) {
			update_post_meta( $post->ID, '_syseze_cover_url', $base . $file );
		}
	}

	update_option( 'syseze_blog_covers_local_v1', '1' );
}
add_action( 'init', 'syseze_update_blog_covers', 100 );

/* ─── one-time update: strip byline divs from existing post content ─── */
function syseze_remove_blog_bylines() {
	if ( get_option( 'syseze_blog_no_byline_v1' ) ) {
		return;
	}
	$slugs = [
		'zero-trust-isnt-a-product',
		'migrating-12000-vms-in-90-days',
		'helpdesk-that-closes-its-own-tickets',
	];
	foreach ( $slugs as $slug ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $post ) {
			continue;
		}
		$content = preg_replace(
			'/<div\s+class="uplink-byline">[\s\S]*?<\/div>\s*<\/div>/i',
			'',
			$post->post_content
		);
		wp_update_post( [ 'ID' => $post->ID, 'post_content' => $content ] );
	}
	update_option( 'syseze_blog_no_byline_v1', '1' );
}
add_action( 'init', 'syseze_remove_blog_bylines', 101 );

/* ─── one-time update: replace Unsplash hero image hotlinks with local files ─── */
function syseze_localise_blog_heroes() {
	if ( get_option( 'syseze_blog_local_heroes_v1' ) ) {
		return;
	}
	$base = get_template_directory_uri() . '/assets/images/blog/';
	$map  = [
		'zero-trust-isnt-a-product'            => [
			'unsplash' => 'photo-1614064641938-3bbee52942c7',
			'local'    => $base . 'zero-trust-hero.jpg',
		],
		'migrating-12000-vms-in-90-days'       => [
			'unsplash' => 'photo-1558494949-ef010cbdcc31',
			'local'    => $base . 'migration-hero.jpg',
		],
		'helpdesk-that-closes-its-own-tickets' => [
			'unsplash' => 'photo-1531746790731-6c087fecd65a',
			'local'    => $base . 'helpdesk-hero.jpg',
		],
	];
	foreach ( $map as $slug => $imgs ) {
		$post = get_page_by_path( $slug, OBJECT, 'post' );
		if ( ! $post ) {
			continue;
		}
		$content = str_replace(
			'https://images.unsplash.com/' . $imgs['unsplash'],
			$imgs['local'],
			$post->post_content
		);
		wp_update_post( [ 'ID' => $post->ID, 'post_content' => $content ] );
	}
	update_option( 'syseze_blog_local_heroes_v1', '1' );
}
add_action( 'init', 'syseze_localise_blog_heroes', 102 );
