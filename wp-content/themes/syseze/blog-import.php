<?php
/**
 * One-time blog post importer.
 * Visit: https://syseze.com/wp-content/themes/syseze/blog-import.php?key=syseze_import_2026
 * DELETE THIS FILE after running.
 */

if ( ( $_GET['key'] ?? '' ) !== 'syseze_import_2026' ) {
	http_response_code( 403 );
	die( 'Forbidden.' );
}

require_once '../../../../wp-load.php';

if ( ! current_user_can( 'publish_posts' ) && ! defined( 'DOING_CRON' ) ) {
	// Allow running even without being logged in, since key protects it.
}

$results = [];

/* ── helpers ── */
function si_ensure_category( $name, $slug ) {
	$existing = get_term_by( 'slug', $slug, 'category' );
	if ( $existing ) return $existing->term_id;
	$term = wp_insert_term( $name, 'category', [ 'slug' => $slug ] );
	return is_wp_error( $term ) ? 0 : $term['term_id'];
}

function si_post_exists( $slug ) {
	return (bool) get_page_by_path( $slug, OBJECT, 'post' );
}

/* ══════════════════════════════════════════
   POST 1 — Zero Trust isn't a product.
══════════════════════════════════════════ */
$cat_security = si_ensure_category( 'Security', 'security' );

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
  <div class="uplink-byline">
    <div><span class="name">Priya Anand</span> — Principal Security Engineer</div>
  </div>
</article>
HTML;

if ( si_post_exists( 'zero-trust-isnt-a-product' ) ) {
	$results[] = '⚠️  Post 1 already exists — skipped.';
} else {
	$id = wp_insert_post( [
		'post_title'   => "Zero Trust isn't a product. It's a posture.",
		'post_name'    => 'zero-trust-isnt-a-product',
		'post_content' => $post1_content,
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_date'    => '2026-05-14 09:00:00',
		'post_category'=> [ $cat_security ],
	] );
	$results[] = is_wp_error( $id ) ? '❌ Post 1 failed: ' . $id->get_error_message() : '✅ Post 1 created — ID ' . $id;
}

/* ══════════════════════════════════════════
   POST 2 — Migrating 12,000 VMs in 90 days
══════════════════════════════════════════ */
$cat_cloud = si_ensure_category( 'Cloud Migration', 'cloud-migration' );

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
  <div class="uplink-byline">
    <div><span class="name">Dana Okafor</span> — Director of Platform Engineering</div>
  </div>
</article>
HTML;

if ( si_post_exists( 'migrating-12000-vms-in-90-days' ) ) {
	$results[] = '⚠️  Post 2 already exists — skipped.';
} else {
	$id = wp_insert_post( [
		'post_title'   => 'What we learned migrating 12,000 VMs in 90 days.',
		'post_name'    => 'migrating-12000-vms-in-90-days',
		'post_content' => $post2_content,
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_date'    => '2026-04-28 09:00:00',
		'post_category'=> [ $cat_cloud ],
	] );
	$results[] = is_wp_error( $id ) ? '❌ Post 2 failed: ' . $id->get_error_message() : '✅ Post 2 created — ID ' . $id;
}

/* ══════════════════════════════════════════
   POST 3 — The helpdesk that closes its own tickets
══════════════════════════════════════════ */
$cat_automation = si_ensure_category( 'Automation', 'automation' );

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
  <p>On a Tuesday in January, a junior accountant named Renée filed ticket #44912: "Outlook keeps asking for my password." By the time the human on shift opened the queue at 8:47 a.m., the ticket was closed. The resolution note said the user's MFA token had drifted, a fresh one had been issued, the offending cached credential had been cleared from her keychain, and she had been emailed a two-line explanation with a screenshot. Renée had already replied: thanks.</p>
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
<p>Renée, for what it's worth, no longer files tickets about Outlook. She did file one last week about a strange networking issue at a co-working space in Berlin. The agent took one look and routed it to a human with the note: "Out of scope. Recommend a human conversation; user's location and corporate VPN policy interact in ways I am not confident about." That ticket took us a real forty minutes to resolve. It was a good forty minutes.</p>
  <div class="uplink-byline">
    <div><span class="name">Marcus Lee</span> — Head of IT Operations</div>
  </div>
</article>
HTML;

if ( si_post_exists( 'helpdesk-that-closes-its-own-tickets' ) ) {
	$results[] = '⚠️  Post 3 already exists — skipped.';
} else {
	$id = wp_insert_post( [
		'post_title'   => 'The helpdesk that closes its own tickets.',
		'post_name'    => 'helpdesk-that-closes-its-own-tickets',
		'post_content' => $post3_content,
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_date'    => '2026-05-07 09:00:00',
		'post_category'=> [ $cat_automation ],
	] );
	$results[] = is_wp_error( $id ) ? '❌ Post 3 failed: ' . $id->get_error_message() : '✅ Post 3 created — ID ' . $id;
}

/* ── output ── */
?>
<!doctype html><html><head><meta charset="utf-8"><title>Blog Import</title>
<style>body{font-family:monospace;background:#0f172a;color:#e2e8f0;padding:40px;} .ok{color:#4ade80;} .warn{color:#fbbf24;} .err{color:#f87171;} h2{color:#06b6d4;}</style>
</head><body>
<h2>SysEze Blog Importer</h2>
<?php foreach ( $results as $r ) echo '<p>' . esc_html( $r ) . '</p>'; ?>
<p style="margin-top:32px;color:#64748b;">⚠️ Delete <code>blog-import.php</code> from the theme folder now.</p>
</body></html>
