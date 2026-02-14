# Project scaffold templates

When you run **`bin/semitexa init`** or **`bin/semitexa init --only-docs --force`**, the framework writes these files from templates in **resources/init/** (inside this package):

| Written to project | Template in core |
|--------------------|------------------|
| `AI_ENTRY.md` | `resources/init/AI_ENTRY.md` |
| `docs/AI_CONTEXT.md` | `resources/init/docs/AI_CONTEXT.md` |
| `README.md` | `resources/init/README.md` |
| `server.php`, `.env.example`, `Dockerfile`, `docker-compose.yml`, `phpunit.xml.dist`, `bin/semitexa`, `.gitignore`, `public/.htaccess` | `resources/init/<filename>` |

**Important:** Any change to the content of these files in the project root will be overwritten the next time you run `semitexa init` or `semitexa init --only-docs --force`. To change what gets generated, edit the templates in **resources/init/** in the semitexa/core package (or in your fork) and then re-run init.

The template for **docs/AI_CONTEXT.md** (entry point for philosophy and AI context) is in [resources/init/docs/AI_CONTEXT.md](../../resources/init/docs/AI_CONTEXT.md). A copy is kept in this folder for reference: [AI_CONTEXT.md](AI_CONTEXT.md).
