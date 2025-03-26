<a name="readme-top"></a>


<!-- PROJECT LOGO -->
<br />
<div align="center">

<h3 align="center">Family History Checks</h3>

  <p align="center">
    A simple app to help make your Family History research easier.
    <br />
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project

Amongst all my many hobbies is researching my family history, which I have been doing on and off (well, more off actually) for the last 30 years. Over that time, how you research has changed enormously with so many records now being available online. Also, when I first started, the only way to record your information was on paper, but now there are numerous software packages that have largely replaced the need for paper.

### Data Mining

The main issue with recording your family history information in a software package is that you are beholden to the developer's choice of what is displayed and how. If you want more flexibility, you need to get your information out and manipulate it in some third-party tool. The de facto standard for exporting genealogical data is GEDCOM, but that is a flat text file, and there's not much you can do with it other than use it to reimport into another program.

### SQL has entered the building

Of course, what you really want to be able to do is manipulate the data using SQL, writing queries to extract the information and then formatting it for display. This is what this app does - provides some useful family history queries wrapped in a simple user interface.

<a href='https://ko-fi.com/Y8Y0POEES' target='_blank'><img height='36' style='border:0px;height:36px;' src='https://storage.ko-fi.com/cdn/kofi5.png?v=6' border='0' alt='Buy Me a Coffee at ko-fi.com' /></a>

![](https://www.spokenlikeageek.com/wp-content/uploads/2025/03/Screenshot-2025-03-23-at-13.37.26.png)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With

* [PHP](https://php.net)
* [SQLite](https://www.sqlite.org/)
* [SQLite Tools for RootsMagic](https://sqlitetoolsforrootsmagic.com)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started

Running the script is very straightforward:

1. download the code/clone the repository

You can read more about how this all works in [this blog post](https://www.spokenlikeageek.com/2024/12/16/what-should-i-play-next/).

### Prerequisites

Requirements are very simple, it requires the following:

1. PHP (I tested on v8.3.14)
2. a RootsMagic SQLite database.

### Installation

1. Clone the repo:
   ```sh
   git clone https://github.com/williamsdb/family-history-checks.git
   ```
2. rename config_dummy.php to config.php and changes the settings in it.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- USAGE EXAMPLES -->
## Usage

Install and point your browser at wherever you put it!

Rather than retrieving the information from Plex everytime you access it data is cached in a local SQLite database. By default the cache is refreshed every 7 days but if you want to force a recache of the information go to the following page:

https://<your domain>?page=recache

_For more information, please refer to the [this blog post](https://www.spokenlikeageek.com/2024/12/16/what-should-i-play-next/)_

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ROADMAP -->
## Known Issues

If your Plex server doesn't have a secure connection (http) and you install What Should I Watch Next? on a secure connection (https) you won't see any images on the last page and will see "Mixed Content" messages in the browser console:

```Mixed Content: The page at '<URL>' was loaded over HTTPS, but requested an insecure element '<URL>'. This request was automatically upgraded to HTTPS, For more information see <URL>```

To avoid this you have three choices:

1. install a certficate on you Plex server
2. run What Should I Watch Next? over an insecure connection (http)
3. add an exception in the browser for the mixed content on this site.


See the [open issues](https://github.com/williamsdb/family-history-checks/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- LICENSE -->
## License

Distributed under the GNU General Public License v3.0. See `LICENSE` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Bluesky - [@spokenlikeageek.com](https://bsky.app/profile/spokenlikeageek.com)

Mastodon - [@spokenlikeageek](https://techhub.social/@spokenlikeageek)

X - [@spokenlikeageek](https://x.com/spokenlikeageek) 

Website - [https://spokenlikeageek.com](https://www.spokenlikeageek.com/tag/family-history-checks/)

Project link - [Github](https://github.com/williamsdb/family-history-checks)

<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* None.

<p align="right">(<a href="#readme-top">back to top</a>)</p>

[![](https://github.com/williamsdb/family-history-checks/graphs/contributors)](https://img.shields.io/github/contributors/williamsdb/family-history-checks.svg?style=for-the-badge)

![](https://img.shields.io/github/contributors/williamsdb/family-history-checks.svg?style=for-the-badge)
![](https://img.shields.io/github/forks/williamsdb/family-history-checks.svg?style=for-the-badge)
![](https://img.shields.io/github/stars/williamsdb/family-history-checks.svg?style=for-the-badge)
![](https://img.shields.io/github/issues/williamsdb/family-history-checks.svg?style=for-the-badge)


<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/github_username/repo_name.svg?style=for-the-badge
[contributors-url]: https://github.com/github_username/repo_name/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/github_username/repo_name.svg?style=for-the-badge
[forks-url]: https://github.com/github_username/repo_name/network/members
[stars-shield]: https://img.shields.io/github/stars/github_username/repo_name.svg?style=for-the-badge
[stars-url]: https://github.com/github_username/repo_name/stargazers
[issues-shield]: https://img.shields.io/github/issues/github_username/repo_name.svg?style=for-the-badge
[issues-url]: https://github.com/github_username/repo_name/issues
[license-shield]: https://img.shields.io/github/license/github_username/repo_name.svg?style=for-the-badge
[license-url]: https://github.com/github_username/repo_name/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/linkedin_username
[product-screenshot]: images/screenshot.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Next-url]: https://nextjs.org/
[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB
[React-url]: https://reactjs.org/
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Angular.io]: https://img.shields.io/badge/Angular-DD0031?style=for-the-badge&logo=angular&logoColor=white
[Angular-url]: https://angular.io/
[Svelte.dev]: https://img.shields.io/badge/Svelte-4A4A55?style=for-the-badge&logo=svelte&logoColor=FF3E00
[Svelte-url]: https://svelte.dev/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com 
