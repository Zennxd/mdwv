<h1 id="mdwv">mdwv</h1>
<h2 id="a-markdown-web-viewer">A markdown web viewer</h2>
<h3 id="live-example"><a href="https://lgajewski.de/mdwv">Live Example</a></h3>
<p>Drop your markdown files in <strong>mdwv/files</strong> to access them on your site!
The markdown files get converted to HTML <em>(and cached)</em></p>
<h3 id="installation">Installation</h3>
<p><em>(Debian - Apache2 - PHP)</em>:</p>
<div class="sourceCode" id="cb1"><pre class="sourceCode bash"><code class="sourceCode bash"><a class="sourceLine" id="cb1-1" title="1"><span class="fu">sudo</span> apt update <span class="kw">&amp;&amp;</span> <span class="fu">sudo</span> apt upgrade          <span class="co"># update packages</span></a>
<a class="sourceLine" id="cb1-2" title="2"><span class="fu">sudo</span> apt-get -y install pandoc               <span class="co"># pandoc converts the markdown files</span></a>
<a class="sourceLine" id="cb1-3" title="3"><span class="bu">cd</span> /var/www/html                             <span class="co"># alternatively: your custom webdir</span></a>
<a class="sourceLine" id="cb1-4" title="4"><span class="fu">git</span> clone https://github.com/Zennxd/mdwv.git <span class="co"># clones this repo into your webdir</span></a>
<a class="sourceLine" id="cb1-5" title="5"><span class="bu">cd</span> mdwv/files                                <span class="co"># folder for your markdown files :-)</span></a></code></pre></div>
<p>Make sure your webserver-user has rw-rights for <strong>files</strong> and <strong>.files_cached</strong>.</p>