# Render (staging)

A shareable staging copy of the site on Render, rebuilt on every push
to `main`. The live site goes on Hostinger; this is not that.

## Deploy

1. Open https://render.com/deploy?repo=https://github.com/itsmearyanabc/rakled-website-
   (or: Render dashboard → **New → Blueprint** → this repository).
2. Sign in, check the service is **rian-cullet**, plan **Free**, then **Apply**.
3. First build takes about 5 minutes. The site is then at
   `https://rian-cullet.onrender.com` (Render adds a suffix if the name
   is taken; the dashboard shows the real URL).

To log in to wp-admin: user `admin`, password from **rian-cullet →
Environment → WP_ADMIN_PASSWORD** (Render generated it).

## What to expect on the free plan

- **It sleeps.** After 15 minutes with no visitors the service stops;
  the next visit wakes it in roughly 30–60 seconds. Fine for showing
  the site to someone, not for real traffic.
- **Nothing you change is kept.** The filesystem resets on every
  restart and deploy, so the site always comes back exactly as built.
  Edits in wp-admin, uploaded media and enquiries submitted through the
  form are lost when it sleeps. The design itself is in the theme, so
  nothing visible depends on them.
- **It is hidden from search engines** (noindex), so it never competes
  with the live site.
- **No email.** Enquiry notifications cannot be sent from Render.
- **wp-admin cannot install plugins or themes.** Deliberate: this copy
  is public, and code changes should come through git.

## Making it persistent (paid)

If wp-admin changes need to stick, add a disk. In `render.yaml`:

```yaml
    plan: starter
    disk:
      name: data
      mountPath: /var/www/data
      sizeGB: 1
```

The database, salts and uploads all live in `/var/www/data`. The first
start on an empty disk seeds it from the build; later starts leave it
alone. This costs the Starter instance plus the disk, per Render's
current pricing. For a site going to Hostinger anyway, the free plan is
usually enough.

## How it is built

`Dockerfile` installs WordPress into SQLite at build time, activates the
theme and runs the theme's own "Create pages and menus" routine
(`build-site.sh`), so the image is a finished site. `start.sh` puts the
database in place, applies the admin password and binds Apache to
Render's port.

Test it locally before pushing (Docker Desktop, from the repo root):

```bash
docker build -f deploy/render/Dockerfile -t rian-cullet-render .
docker run --rm -p 10000:10000 -e PORT=10000 -e WP_ADMIN_PASSWORD=choose-one rian-cullet-render
```

Then open http://localhost:10000.
