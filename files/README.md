# mdwv
## A markdown web viewer
### [Live Example](https://lgajewski.de/mdwv)

Drop your markdown files in **mdwv/files** to access them on your site!
The markdown files get converted to HTML *(and cached)*

### Installation
*(Debian - Apache2 - PHP)*:
```bash
sudo apt update && sudo apt upgrade          # update packages
sudo apt-get -y install pandoc               # pandoc converts the markdown files
cd /var/www/html                             # alternatively: your custom webdir
git clone https://github.com/Zennxd/mdwv.git # clones this repo into your webdir
cd mdwv/files                                # folder for your markdown files :-)
```
Make sure your webserver-user has rw-rights for **files** and **.files_cached**.