# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [1.0.0] - 2025-11-15

### Added

#### Core Features
- **Public Interface** (`/`) - Simple Markdown to HTML converter
  - Real-time conversion with Marked.js
  - Live preview with beautiful formatting
  - HTML export with embedded styles
  - Copy to clipboard functionality
  - Sample markdown templates
  - RTL and Arabic support

- **Lab Interface** (`/lab`) - Advanced testing and experimentation
  - Multi-engine testing (Marked.js, CommonMark, Rust*, Python*)
  - Performance benchmarking tools
  - Detailed statistics (time, memory, size)
  - Engine comparison interface
  - Experiments section (future)

#### Backend
- Laravel 12.10.1 setup with SQLite
- `PublicController` - Handles public conversion
  - `index()` - Display main page
  - `convert()` - API endpoint for conversion
- `LabController` - Advanced testing
  - `index()` - Display lab page
  - `testEngine()` - API for engine testing
  - Multi-engine support architecture

#### Frontend
- Responsive Tailwind CSS design
- RTL-ready with Cairo Arabic font
- Interactive JavaScript features
- Beautiful markdown output styling
- Real-time notifications
- Keyboard shortcuts (Ctrl+Enter to convert)

#### API Endpoints
- `POST /convert` - Convert Markdown using CommonMark
- `POST /lab/test-engine` - Test engines with detailed stats

#### Documentation
- `README.md` - Comprehensive main documentation
- `QUICK_START.md` - 3-minute setup guide
- `CONTRIBUTING.md` - Contribution guidelines
- `PROJECT_SUMMARY.md` - Complete project overview
- `CHANGELOG.md` - This file

#### Engines
- ✅ Marked.js 15.0 (JavaScript) - Active
- ✅ League CommonMark 2.7 (PHP) - Active
- 🔜 Rust (pulldown-cmark) - Coming soon
- 🔜 Python (python-markdown) - Coming soon

#### Development
- GitHub repository created
- Git workflow established
- Code standards defined
- Testing structure prepared

### Changed
- Updated `.env.example` with project-specific settings
- Enhanced Laravel routes for dual interface architecture

### Technical Details

**Dependencies:**
- Laravel 12.10.1
- League CommonMark 2.7
- Marked.js 15.0 (CDN)
- Tailwind CSS (CDN)

**Performance:**
- Marked.js: ~5,400 ops/sec
- CommonMark: ~500 ops/sec
- Target for Rust: 100,000+ ops/sec
- Target for Python: 2,000 ops/sec

**File Statistics:**
- Controllers: 2 files, 334 lines
- Views: 3 files, 810 lines
- Documentation: 5 files, 1,500+ lines
- Total commits: 5

---

## [Unreleased]

### Planned for v1.1.0

#### Features
- [ ] Rust Engine Integration
  - CLI wrapper for pulldown-cmark
  - Microservice architecture
  - Support for large files (1MB+)

- [ ] Python Engine for RTL
  - Python microservice
  - Automatic Arabic detection
  - RTL text processing
  - 40+ markdown extensions

- [ ] Theme System
  - 20+ pre-built themes
  - Theme selector UI
  - Custom theme support
  - GitHub, Dark, Ocean, Sunset styles

#### Improvements
- [ ] Enhanced error handling
- [ ] Rate limiting for API
- [ ] Caching system
- [ ] Performance optimizations

### Planned for v1.2.0

#### Export Features
- [ ] PDF Export
  - Puppeteer integration
  - Professional templates
  - Custom styling

- [ ] DOCX Export
  - python-docx integration
  - Template support
  - Image embedding

#### Advanced Features
- [ ] Advanced plugins system
- [ ] Custom markdown extensions
- [ ] Syntax highlighting themes
- [ ] Math equation support (LaTeX)

### Planned for v2.0.0

#### Major Features
- [ ] Multi-language UI
- [ ] Real-time collaboration
- [ ] Cloud storage integration
- [ ] User accounts and history
- [ ] API authentication
- [ ] Webhook support

---

## Version History

### [1.0.0] - 2025-11-15
- Initial release
- Public and Lab interfaces
- Marked.js and CommonMark engines
- Comprehensive documentation
- GitHub repository

---

## Links

- **Repository**: https://github.com/MrTurki2/markdown-to-html
- **Issues**: https://github.com/MrTurki2/markdown-to-html/issues
- **Releases**: https://github.com/MrTurki2/markdown-to-html/releases

---

## Contributors

Special thanks to all contributors who helped build this project!

- [@MrTurki2](https://github.com/MrTurki2) - Creator and maintainer

---

**Note:** Dates are in YYYY-MM-DD format. All times are in UTC.
