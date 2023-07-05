<?php
global $post;

$img_identita = dsi_get_option("immagine", "la_scuola");
//$id_scuola_principale = dsi_get_option("scuola_principale", "homepage");
$landing_url = dsi_get_template_page_url("page-templates/la-scuola.php");

$colid=6;
$showimage = true;
if($img_identita == ""){
    // se non è stata caricata una immagine apro a schermo pieno
    $colid = 12;
    $showimage = false;
}
?><section class="section bg-redbrown section-hero-left" style="background-image: url('<?php echo $img_identita; ?>');">
    <div class="decoration-01 sr-only sr-only-focusable">
        <svg width="100%" height="100%" viewBox="0 0 312 311" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
              <path d="M206.727,152.114c0,-20.571 -12.385,-39.116 -31.381,-46.988c-18.996,-7.872 -40.86,-3.521 -55.399,11.025c-14.538,14.545 -18.888,36.421 -11.019,55.426c7.868,19.004 26.404,31.396 46.965,31.396c28.061,-0.032 50.802,-22.784 50.834,-50.859Zm-50.834,44.078c-24.332,0 -44.057,-19.735 -44.057,-44.078c0,-24.344 19.725,-44.078 44.057,-44.078c24.331,0 44.056,19.734 44.056,44.078c-0.027,24.332 -19.736,44.051 -44.056,44.078Zm-88.114,-44.078c0,48.687 39.45,88.156 88.114,88.156c48.663,0 88.113,-39.469 88.113,-88.156c0,-48.688 -39.45,-88.157 -88.113,-88.157c-48.641,0.056 -88.059,39.492 -88.114,88.157Zm169.449,0c0,44.942 -36.415,81.374 -81.335,81.374c-44.921,0 -81.336,-36.432 -81.336,-81.374c0,-44.943 36.415,-81.375 81.336,-81.375c44.898,0.051 81.283,36.454 81.335,81.375Zm-145.014,27.802c0.361,0.827 0.378,1.764 0.047,2.604c-0.331,0.84 -0.982,1.513 -1.809,1.872c-0.428,0.186 -0.89,0.279 -1.356,0.27c-1.349,-0.003 -2.571,-0.799 -3.119,-2.033c-0.358,-0.822 -0.373,-1.754 -0.042,-2.587c0.331,-0.834 0.98,-1.501 1.804,-1.855c1.713,-0.749 3.71,0.022 4.475,1.729Zm-11.896,-38.009c0.238,-1.796 1.847,-3.086 3.651,-2.927c1.804,0.159 3.163,1.71 3.084,3.52c-0.079,1.81 -1.569,3.237 -3.379,3.238c-0.148,0.005 -0.296,-0.006 -0.441,-0.033c-1.851,-0.246 -3.155,-1.945 -2.915,-3.798l0,0Zm3.863,23.633c-0.156,0.029 -0.315,0.04 -0.474,0.034c-1.808,-0.002 -3.295,-1.424 -3.379,-3.231c-0.084,-1.806 1.265,-3.36 3.064,-3.53c1.8,-0.17 3.415,1.104 3.67,2.895l0.033,0c0.243,1.86 -1.057,3.569 -2.914,3.832Zm17.893,30.516c1.175,1.455 0.964,3.583 -0.473,4.78c-0.613,0.499 -1.378,0.775 -2.169,0.779c-1.578,-0.007 -2.943,-1.1 -3.297,-2.638c-0.353,-1.538 0.397,-3.118 1.813,-3.814c1.416,-0.697 3.125,-0.327 4.126,0.893Zm13.828,12.918c0.735,0.515 1.234,1.302 1.387,2.187c0.153,0.884 -0.054,1.793 -0.573,2.525c-0.621,0.903 -1.65,1.437 -2.745,1.424c-0.702,-0.003 -1.386,-0.215 -1.966,-0.609c-1.52,-1.079 -1.881,-3.185 -0.806,-4.708c1.074,-1.523 3.177,-1.889 4.703,-0.819Zm87.233,-107.822c-1.36,-1.277 -1.435,-3.412 -0.169,-4.781c1.266,-1.369 3.4,-1.46 4.777,-0.203c1.369,1.286 1.444,3.436 0.169,4.815c-1.288,1.333 -3.399,1.408 -4.778,0.169l0.001,0Zm-117.259,20.716c0.682,-1.542 2.396,-2.344 4.017,-1.881c1.62,0.464 2.651,2.051 2.416,3.72c-0.235,1.67 -1.663,2.911 -3.349,2.909c-0.453,-0.008 -0.901,-0.1 -1.322,-0.271c-0.828,-0.359 -1.48,-1.032 -1.81,-1.873c-0.331,-0.84 -0.314,-1.777 0.048,-2.604Zm129.256,-6.103c-0.719,-1.168 -0.662,-2.654 0.143,-3.764c0.805,-1.11 2.2,-1.624 3.533,-1.303c1.333,0.321 2.34,1.415 2.551,2.77c0.212,1.355 -0.414,2.704 -1.586,3.417c-0.528,0.332 -1.138,0.508 -1.762,0.508c-1.177,-0.006 -2.267,-0.622 -2.879,-1.628Zm5.93,75.985c-0.621,1.015 -1.726,1.631 -2.915,1.627c-0.612,-0.006 -1.21,-0.182 -1.728,-0.508c-1.175,-0.713 -1.805,-2.064 -1.593,-3.423c0.211,-1.358 1.22,-2.455 2.556,-2.777c1.336,-0.322 2.735,0.194 3.541,1.307c0.806,1.114 0.861,2.604 0.139,3.774l0,0Zm-66.695,33.33c-0.104,1.775 -1.577,3.16 -3.354,3.152l-0.239,0c-1.862,-0.122 -3.272,-1.731 -3.15,-3.594c0.122,-1.863 1.73,-3.275 3.592,-3.152c1.862,0.122 3.273,1.731 3.151,3.594Zm-19.588,-3.086c-0.498,1.348 -1.784,2.241 -3.22,2.238c-0.38,0.01 -0.759,-0.048 -1.119,-0.17c-1.768,-0.628 -2.693,-2.571 -2.066,-4.341c0.627,-1.769 2.57,-2.695 4.338,-2.067c1.769,0.627 2.694,2.57 2.067,4.34Zm51.411,-136.269c0.399,-0.805 1.104,-1.417 1.958,-1.697c0.853,-0.28 1.784,-0.206 2.582,0.205l0.035,0c1.654,0.871 2.303,2.909 1.456,4.576c-0.579,1.132 -1.746,1.84 -3.016,1.831c-0.543,0.01 -1.08,-0.118 -1.559,-0.372c-0.796,-0.409 -1.396,-1.118 -1.669,-1.97c-0.273,-0.852 -0.197,-1.778 0.213,-2.573Zm-19.014,-5.73c0.242,-1.187 1.099,-2.155 2.248,-2.539c1.149,-0.384 2.415,-0.126 3.322,0.678c0.907,0.803 1.316,2.03 1.074,3.217c-0.337,1.57 -1.716,2.696 -3.321,2.712c-0.228,-0.004 -0.455,-0.026 -0.678,-0.068c-0.884,-0.175 -1.66,-0.696 -2.157,-1.448c-0.497,-0.751 -0.673,-1.67 -0.488,-2.552Zm61.579,68.422c0.9,-0.003 1.764,0.353 2.4,0.989c0.636,0.637 0.992,1.501 0.989,2.401l0,0.307c0,1.872 -1.517,3.39 -3.389,3.39c-1.871,0 -3.389,-1.518 -3.389,-3.39l0,-0.272c-0.01,-0.905 0.343,-1.777 0.979,-2.421c0.637,-0.644 1.505,-1.005 2.41,-1.004Zm-117.801,-53.775c-1.079,-1.537 -0.715,-3.657 0.814,-4.747c1.525,-1.068 3.627,-0.701 4.701,0.821c1.073,1.522 0.714,3.626 -0.804,4.706c-0.555,0.422 -1.234,0.648 -1.931,0.644c-1.101,-0.002 -2.135,-0.531 -2.78,-1.424Zm63.136,128.165c0.186,0.877 0.015,1.791 -0.475,2.542c-0.489,0.751 -1.257,1.276 -2.134,1.459c-0.236,0.04 -0.474,0.063 -0.712,0.068c-1.728,-0.019 -3.166,-1.334 -3.339,-3.054c-0.173,-1.72 0.973,-3.296 2.662,-3.659c1.833,-0.371 3.621,0.811 3.998,2.644l0,0Zm18.369,-7.527c0.531,1.049 0.485,2.296 -0.122,3.302c-0.606,1.006 -1.687,1.629 -2.861,1.649c-1.266,-0.007 -2.425,-0.711 -3.015,-1.831c-0.563,-1.073 -0.51,-2.365 0.14,-3.387c0.65,-1.023 1.797,-1.619 3.007,-1.564c1.21,0.055 2.298,0.754 2.851,1.832l0,-0.001Zm-64.357,-130.674c-0.31,-0.84 -0.27,-1.771 0.113,-2.581c0.382,-0.81 1.075,-1.432 1.921,-1.725c1.138,-0.412 2.409,-0.185 3.334,0.595c0.926,0.781 1.365,1.996 1.152,3.187c-0.213,1.192 -1.045,2.18 -2.183,2.592c-0.848,0.309 -1.786,0.265 -2.602,-0.124c-0.815,-0.389 -1.44,-1.089 -1.735,-1.944l0,0Zm19.215,-4.985c-0.12,-1.86 1.285,-3.467 3.143,-3.594c1.859,-0.127 3.47,1.274 3.603,3.133c0.134,1.858 -1.261,3.475 -3.118,3.615l-0.239,0c-1.785,0.01 -3.269,-1.372 -3.388,-3.154l-0.001,0Zm82.014,93.073c-0.403,1.465 -1.735,2.479 -3.253,2.475c-0.311,0.006 -0.62,-0.04 -0.915,-0.135c-0.864,-0.242 -1.595,-0.818 -2.034,-1.6c-0.438,-0.783 -0.548,-1.707 -0.305,-2.571c0.318,-1.174 1.241,-2.087 2.418,-2.391c1.177,-0.305 2.426,0.047 3.272,0.921c0.846,0.873 1.158,2.134 0.817,3.301l0,0Zm-21.216,30.347c1.286,1.369 1.226,3.52 -0.135,4.814c-0.66,0.617 -1.539,0.946 -2.442,0.914c-0.902,-0.032 -1.755,-0.422 -2.37,-1.084c-1.27,-1.369 -1.196,-3.507 0.165,-4.784c1.362,-1.278 3.498,-1.215 4.783,0.14l-0.001,0Zm14.607,-69.95c-0.515,-1.807 0.532,-3.69 2.338,-4.205c1.806,-0.515 3.688,0.532 4.203,2.339c0.515,1.807 -0.532,3.69 -2.338,4.205c-0.299,0.078 -0.606,0.124 -0.915,0.136c-1.523,-0.005 -2.861,-1.012 -3.288,-2.475l0,0Zm-125.595,-24.208c-0.952,-0.759 -1.424,-1.971 -1.235,-3.174c0.189,-1.203 1.009,-2.213 2.148,-2.643c1.138,-0.431 2.421,-0.217 3.358,0.561c0.697,0.563 1.14,1.382 1.229,2.274c0.089,0.892 -0.182,1.782 -0.754,2.472c-0.625,0.805 -1.591,1.27 -2.61,1.255c-0.778,0.013 -1.535,-0.251 -2.136,-0.745Zm48.531,105.075c-0.193,0.005 -0.385,-0.006 -0.576,-0.033c-1.846,-0.331 -3.084,-2.083 -2.78,-3.934c0.306,-1.768 1.936,-2.992 3.718,-2.791c1.783,0.201 3.099,1.758 3.003,3.55c-0.096,1.792 -1.571,3.198 -3.365,3.208Zm17.012,-120.91c0.307,-1.768 1.938,-2.99 3.719,-2.788c1.782,0.202 3.098,1.759 3.001,3.55c-0.097,1.791 -1.572,3.197 -3.365,3.206c-0.193,0.007 -0.386,-0.005 -0.576,-0.035c-1.851,-0.321 -3.094,-2.08 -2.779,-3.933Zm49.14,59.066l0,-0.239c-0.009,-1.872 1.501,-3.398 3.373,-3.407c1.872,-0.009 3.396,1.501 3.405,3.374l0,0.272c0,1.872 -1.517,3.39 -3.389,3.39c-1.871,0 -3.389,-1.518 -3.389,-3.39Zm-24.536,54.317c-1.631,0.917 -3.696,0.359 -4.644,-1.255c-0.922,-1.62 -0.361,-3.681 1.255,-4.61c0.77,-0.46 1.693,-0.589 2.56,-0.36c0.867,0.23 1.606,0.799 2.048,1.58c0.457,0.777 0.586,1.704 0.357,2.576c-0.229,0.873 -0.797,1.617 -1.576,2.069Zm-83.978,-73.34c-0.484,1.344 -1.758,2.24 -3.186,2.238c-0.393,0.002 -0.784,-0.067 -1.153,-0.203c-1.759,-0.637 -2.669,-2.58 -2.032,-4.34c0.636,-1.76 2.578,-2.671 4.337,-2.034c1.759,0.636 2.67,2.579 2.034,4.339Zm95.296,-17.089c-1.206,-1.432 -1.024,-3.572 0.408,-4.78c1.432,-1.207 3.571,-1.025 4.778,0.407c1.207,1.433 1.025,3.573 -0.407,4.781c-0.608,0.508 -1.377,0.785 -2.169,0.779c-1.001,0.004 -1.954,-0.429 -2.61,-1.187l0,0Zm5.355,76.425c-0.659,0.752 -1.61,1.184 -2.609,1.187c-0.794,0.017 -1.567,-0.261 -2.168,-0.78c-0.696,-0.575 -1.13,-1.406 -1.207,-2.305c-0.077,-0.899 0.212,-1.792 0.8,-2.476l-0.035,0c1.213,-1.418 3.342,-1.595 4.772,-0.396c1.431,1.198 1.63,3.326 0.447,4.77l0,0Zm-21.52,-93.479c0.927,-1.614 2.985,-2.171 4.599,-1.246c1.614,0.925 2.174,2.983 1.251,4.599c-0.923,1.616 -2.98,2.179 -4.596,1.258c-1.61,-0.933 -2.17,-2.99 -1.254,-4.611l0,0Zm-15.588,114.942c-0.202,0.029 -0.407,0.04 -0.611,0.035c-1.789,-0.013 -3.258,-1.418 -3.353,-3.205c-0.094,-1.787 1.219,-3.339 2.996,-3.541c1.777,-0.202 3.405,1.016 3.713,2.779c0.304,1.839 -0.915,3.584 -2.745,3.932Zm43.547,-85.478c1.759,-0.646 3.709,0.257 4.355,2.017c0.646,1.76 -0.256,3.711 -2.016,4.357c-0.37,0.134 -0.76,0.202 -1.153,0.204c-1.644,0.004 -3.055,-1.172 -3.347,-2.792c-0.292,-1.619 0.618,-3.214 2.161,-3.786l0,0Zm-87.198,-25.905c-0.457,-0.777 -0.585,-1.704 -0.355,-2.576c0.229,-0.871 0.796,-1.616 1.576,-2.067c0.771,-0.458 1.693,-0.586 2.56,-0.356c0.866,0.229 1.604,0.797 2.049,1.576c0.456,0.777 0.584,1.704 0.355,2.576c-0.229,0.872 -0.796,1.617 -1.575,2.069c-0.517,0.292 -1.101,0.443 -1.695,0.441c-1.2,0.013 -2.315,-0.622 -2.915,-1.662l0,-0.001Zm-19.824,68.831c0.637,1.76 -0.253,3.706 -2.001,4.374c-0.381,0.133 -0.781,0.202 -1.185,0.204c-1.716,-0.005 -3.158,-1.291 -3.359,-2.996c-0.201,-1.704 0.903,-3.291 2.571,-3.694c1.668,-0.403 3.374,0.504 3.974,2.112Zm111.461,2.237c-0.497,1.328 -1.767,2.208 -3.185,2.205c-0.393,-0.001 -0.782,-0.07 -1.152,-0.204c-0.848,-0.301 -1.54,-0.93 -1.922,-1.745c-0.382,-0.816 -0.422,-1.75 -0.111,-2.595c0.415,-1.143 1.408,-1.976 2.605,-2.185c1.197,-0.209 2.414,0.238 3.191,1.172c0.778,0.934 0.997,2.212 0.574,3.352Zm-118.239,-17.935c-1.872,0 -3.389,-1.518 -3.389,-3.391c0,-1.872 1.517,-3.39 3.389,-3.39c0.896,-0.011 1.759,0.338 2.396,0.968c0.637,0.631 0.994,1.491 0.993,2.387c-0.004,1.877 -1.513,3.404 -3.389,3.426Zm11.623,-38.959c-1.276,-1.054 -1.61,-2.874 -0.791,-4.312c0.819,-1.439 2.553,-2.08 4.11,-1.521c1.557,0.56 2.487,2.159 2.203,3.79c-0.283,1.631 -1.698,2.822 -3.353,2.823c-0.794,0.016 -1.567,-0.262 -2.169,-0.78Zm33.889,-22.379c-0.169,-0.887 0.026,-1.805 0.543,-2.545c0.517,-0.741 1.312,-1.241 2.203,-1.387c0.885,-0.16 1.798,0.039 2.536,0.555c0.738,0.515 1.24,1.303 1.395,2.19c0.304,1.84 -0.914,3.586 -2.745,3.934c-0.202,0.029 -0.406,0.041 -0.611,0.035c-1.633,-0.002 -3.032,-1.173 -3.321,-2.781l0,-0.001Zm-29.415,98.6c-0.677,0.59 -1.564,0.879 -2.459,0.802c-0.895,-0.076 -1.72,-0.513 -2.287,-1.209l-0.033,0c-1.191,-1.438 -1.01,-3.565 0.407,-4.78c1.449,-1.193 3.584,-1.013 4.812,0.406l-0.034,0.034c0.589,0.678 0.878,1.565 0.801,2.46c-0.076,0.894 -0.512,1.719 -1.207,2.287Zm13.624,14.038c-1.544,0.013 -2.903,-1.015 -3.312,-2.505c-0.408,-1.489 0.237,-3.067 1.572,-3.844c1.334,-0.776 3.024,-0.557 4.116,0.535c1.092,1.092 1.313,2.783 0.538,4.118c-0.597,1.048 -1.709,1.694 -2.914,1.696l0,0Zm28.942,-156.58c1.869,0.006 3.383,1.521 3.389,3.391c0.002,0.891 -0.352,1.746 -0.983,2.374c-0.617,0.652 -1.476,1.019 -2.373,1.016c-3.22,0.035 -6.541,0.204 -9.795,0.544c-0.122,0.025 -0.247,0.037 -0.372,0.033c-1.302,-0.012 -2.483,-0.764 -3.045,-1.939c-0.562,-1.174 -0.406,-2.567 0.402,-3.588c0.556,-0.703 1.378,-1.144 2.271,-1.22c3.457,-0.372 6.981,-0.576 10.506,-0.611l0,0Zm39.989,198.996c0.316,0.846 0.292,1.782 -0.068,2.61c-0.37,0.82 -1.054,1.455 -1.898,1.763c-0.379,0.148 -0.78,0.229 -1.187,0.239c-1.639,0.001 -3.046,-1.169 -3.345,-2.782c-0.299,-1.613 0.595,-3.21 2.126,-3.797c1.749,-0.62 3.675,0.247 4.372,1.967l0,0Zm-2.305,-192.215c7.651,2.887 14.941,6.653 21.723,11.224c0.748,0.502 1.265,1.282 1.437,2.166c0.171,0.885 -0.016,1.801 -0.522,2.547c-0.497,0.743 -1.27,1.257 -2.148,1.429c-0.877,0.172 -1.787,-0.013 -2.528,-0.513c-6.36,-4.261 -13.181,-7.787 -20.334,-10.512c-1.759,-0.656 -2.654,-2.613 -2,-4.374c0.697,-1.72 2.623,-2.586 4.372,-1.967l0,0Zm-89.3,11.02c-0.437,-0.785 -0.547,-1.711 -0.304,-2.576c0.381,-1.319 1.517,-2.279 2.88,-2.435c1.363,-0.155 2.686,0.524 3.355,1.723c0.434,0.786 0.544,1.71 0.306,2.576c-0.259,0.863 -0.842,1.592 -1.627,2.035c-0.499,0.275 -1.057,0.426 -1.627,0.44c-1.241,0 -2.383,-0.676 -2.983,-1.763l0,0Zm-52.765,91.004c-0.033,-1.153 -0.068,-2.34 -0.068,-3.628c0,-2.306 0.068,-4.61 0.238,-6.882c0.123,-1.862 1.729,-3.273 3.591,-3.154c0.902,0.054 1.745,0.468 2.338,1.151c0.594,0.682 0.887,1.575 0.814,2.477c-0.135,2.102 -0.203,4.238 -0.203,6.408c0,1.052 0.035,2.204 0.068,3.426c0.043,1.867 -1.421,3.423 -3.287,3.491l-0.103,0c-1.83,-0.006 -3.327,-1.459 -3.388,-3.289Zm168.5,80.121c-0.59,0.464 -1.319,0.714 -2.069,0.713c-0.975,-0.017 -1.898,-0.448 -2.538,-1.185c-0.64,-0.738 -0.936,-1.712 -0.816,-2.681c0.129,-0.892 0.604,-1.696 1.322,-2.239c1.503,-1.075 3.584,-0.792 4.745,0.646c1.11,1.494 0.824,3.602 -0.644,4.746Zm-140.846,-144.475c-4.699,6.045 -8.691,12.609 -11.896,19.564c-0.559,1.198 -1.761,1.965 -3.083,1.967c-0.491,-0.004 -0.975,-0.107 -1.425,-0.305c-0.818,-0.371 -1.452,-1.055 -1.76,-1.899c-0.307,-0.85 -0.271,-1.787 0.101,-2.611c3.434,-7.427 7.709,-14.435 12.741,-20.887c1.173,-1.432 3.265,-1.686 4.746,-0.576c0.714,0.548 1.177,1.359 1.285,2.252c0.109,0.893 -0.147,1.793 -0.709,2.495Zm175.379,53.097c-0.238,-3.187 -0.678,-6.476 -1.254,-9.764c-0.16,-0.886 0.039,-1.8 0.555,-2.538c0.515,-0.739 1.303,-1.241 2.19,-1.396c1.836,-0.294 3.575,0.921 3.932,2.747c0.609,3.425 1.049,6.95 1.32,10.408c0.076,0.9 -0.211,1.794 -0.796,2.481c-0.585,0.688 -1.421,1.113 -2.321,1.182l-0.237,0c-1.769,0.001 -3.243,-1.356 -3.389,-3.12Zm-187.139,49.029c0.373,0.823 0.409,1.76 0.102,2.611c-0.492,1.332 -1.766,2.213 -3.185,2.203c-1.32,-0.01 -2.517,-0.773 -3.085,-1.965c-0.371,-0.812 -0.408,-1.738 -0.102,-2.578c0.464,-1.297 1.667,-2.185 3.044,-2.244c1.376,-0.06 2.651,0.72 3.226,1.973l0,0Zm177.176,-98.803c1.016,1.564 0.576,3.656 -0.983,4.68c-0.541,0.361 -1.179,0.55 -1.83,0.541c-1.617,0.008 -3.013,-1.134 -3.327,-2.721c-0.314,-1.588 0.541,-3.175 2.039,-3.785c1.498,-0.61 3.218,-0.071 4.101,1.285l0,0Zm-138.676,149.458c-7.164,-3.944 -13.85,-8.7 -19.929,-14.171c-1.37,-1.262 -1.476,-3.391 -0.236,-4.782c1.281,-1.355 3.403,-1.459 4.812,-0.236c5.676,5.129 11.931,9.578 18.639,13.256c0,0.009 0.003,0.018 0.01,0.025c0.006,0.006 0.015,0.01 0.025,0.01c0.765,0.431 1.327,1.151 1.559,1.999c0.269,0.86 0.171,1.793 -0.272,2.578c-0.599,1.087 -1.741,1.762 -2.982,1.763c-0.57,-0.014 -1.128,-0.166 -1.626,-0.442Zm50.324,9.699c-0.057,1.818 -1.536,3.268 -3.354,3.288l-0.135,0c-3.492,-0.136 -7.015,-0.441 -10.472,-0.916c-0.891,-0.128 -1.695,-0.603 -2.237,-1.323c-0.544,-0.714 -0.777,-1.619 -0.644,-2.508c0.26,-1.841 1.955,-3.127 3.796,-2.882c3.219,0.44 6.54,0.712 9.793,0.847c0.895,0.031 1.741,0.417 2.351,1.072c0.61,0.655 0.935,1.527 0.902,2.422Zm86.725,-48.08c-0.783,-0.448 -1.356,-1.19 -1.592,-2.062c-0.235,-0.872 -0.114,-1.801 0.338,-2.583c3.819,-6.633 6.856,-13.687 9.048,-21.021c0.552,-1.774 2.418,-2.783 4.203,-2.273c0.87,0.228 1.599,0.821 1.999,1.627c0.442,0.785 0.54,1.718 0.271,2.578c-2.329,7.845 -5.571,15.39 -9.658,22.479c-0.596,1.049 -1.709,1.697 -2.914,1.696c-0.595,0.011 -1.181,-0.142 -1.695,-0.441Zm-194.099,3.742c-3.894,-7.317 -7.03,-15.012 -9.36,-22.966c-0.526,-1.797 0.503,-3.681 2.299,-4.207c1.796,-0.527 3.678,0.503 4.205,2.299c2.2,7.511 5.161,14.776 8.836,21.685c0.57,1.069 0.527,2.361 -0.113,3.389c-0.641,1.029 -1.781,1.637 -2.992,1.595c-1.21,-0.041 -2.306,-0.726 -2.875,-1.795Zm4.102,-121.95c4.379,-7.033 9.457,-13.606 15.158,-19.617c1.288,-1.358 3.433,-1.413 4.79,-0.124c1.357,1.289 1.413,3.435 0.124,4.793c-5.384,5.68 -10.182,11.89 -14.32,18.534c-0.64,1.028 -1.78,1.636 -2.99,1.596c-1.21,-0.041 -2.306,-0.725 -2.876,-1.793c-0.57,-1.069 -0.526,-2.361 0.114,-3.389l0,0Zm-15.065,67.499c0.897,-0.05 1.778,0.259 2.448,0.859c0.67,0.6 1.074,1.442 1.123,2.34c0.306,5.513 1.003,10.997 2.085,16.412c0.378,1.849 -0.784,3.664 -2.621,4.092c-0.24,0.049 -0.484,0.074 -0.728,0.075c-1.565,0.026 -2.929,-1.063 -3.249,-2.596c-0.001,-0.017 -0.048,-0.242 -0.051,-0.257c-1.144,-5.724 -1.881,-11.523 -2.204,-17.352c-0.05,-0.898 0.259,-1.779 0.859,-2.449c0.599,-0.67 1.44,-1.074 2.338,-1.124Zm37.581,-89.722c-1.239,-1.403 -1.108,-3.545 0.293,-4.786c4.429,-3.919 9.137,-7.511 14.087,-10.746c1.567,-1.018 3.662,-0.575 4.683,0.99c1.021,1.565 0.585,3.662 -0.976,4.688c-4.675,3.055 -9.121,6.446 -13.303,10.147c-1.402,1.241 -3.543,1.11 -4.784,-0.293l0,0Zm119.822,-29.035c5.608,1.886 11.071,4.177 16.348,6.854c1.083,0.546 1.793,1.63 1.859,2.842c0.067,1.212 -0.519,2.367 -1.537,3.029c-1.017,0.661 -2.31,0.728 -3.39,0.175c-4.983,-2.527 -10.143,-4.691 -15.438,-6.473c-1.15,-0.384 -2.009,-1.353 -2.25,-2.542c-0.241,-1.189 0.171,-2.416 1.081,-3.218c0.91,-0.802 2.179,-1.057 3.327,-0.667l0,0Zm-145.682,72.749c-1.671,4.148 -3.1,8.39 -4.278,12.705c-0.403,1.474 -1.741,2.496 -3.268,2.498c-0.303,0 -0.604,-0.041 -0.895,-0.121c-1.806,-0.494 -2.87,-2.358 -2.377,-4.165c1.25,-4.567 2.762,-9.058 4.53,-13.45c0.699,-1.737 2.673,-2.579 4.409,-1.879c1.737,0.699 2.578,2.675 1.879,4.412l0,0Zm110.669,-72.236c-1.214,-0.032 -2.318,-0.712 -2.894,-1.782c-0.576,-1.07 -0.536,-2.367 0.106,-3.398c0.641,-1.032 1.786,-1.642 3,-1.598c8.284,0.263 16.519,1.374 24.577,3.318c1.819,0.439 2.939,2.27 2.5,4.091c-0.439,1.82 -2.269,2.94 -4.089,2.501c-7.606,-1.834 -15.38,-2.884 -23.2,-3.132Zm-4.427,233.987c-0.061,1.827 -1.558,3.277 -3.385,3.279l-0.114,-0.002c-8.285,-0.279 -16.519,-1.406 -24.574,-3.363c-1.818,-0.442 -2.934,-2.276 -2.492,-4.096c0.443,-1.819 2.275,-2.935 4.094,-2.493c7.604,1.848 15.376,2.911 23.197,3.174c0.898,0.03 1.748,0.415 2.362,1.072c0.614,0.657 0.942,1.531 0.912,2.429Zm-12.751,-236.706c0.128,0.891 -0.102,1.795 -0.641,2.515c-0.538,0.72 -1.341,1.197 -2.23,1.325c-2.095,0.303 -4.194,0.664 -6.297,1.083c-2.308,0.463 -4.588,0.991 -6.839,1.584c-1.809,0.473 -3.659,-0.61 -4.134,-2.419c-0.476,-1.809 0.602,-3.662 2.41,-4.14c2.378,-0.626 4.789,-1.184 7.235,-1.674c2.222,-0.446 4.441,-0.827 6.658,-1.146c1.851,-0.261 3.565,1.022 3.838,2.872l0,0Zm-73.263,203.868c-3.331,-3.359 -6.464,-6.909 -9.383,-10.632c-1.147,-1.473 -0.887,-3.598 0.581,-4.75c1.469,-1.153 3.593,-0.901 4.751,0.565c2.757,3.515 5.716,6.867 8.863,10.039c1.311,1.331 1.3,3.473 -0.026,4.789c-1.326,1.317 -3.466,1.312 -4.786,-0.011l0,0Zm173.232,-171.963c3.337,3.353 6.477,6.897 9.403,10.614c0.757,0.951 0.948,2.235 0.499,3.365c-0.449,1.13 -1.468,1.934 -2.672,2.105c-1.203,0.172 -2.406,-0.315 -3.152,-1.275c-2.764,-3.51 -5.729,-6.857 -8.88,-10.024c-1.315,-1.328 -1.308,-3.47 0.016,-4.789c1.324,-1.319 3.465,-1.317 4.786,0.004Zm28.773,114.197c1.805,0.497 2.866,2.363 2.37,4.169c-1.257,4.565 -2.778,9.053 -4.556,13.441c-0.702,1.736 -2.678,2.573 -4.413,1.869c-1.734,-0.703 -2.571,-2.68 -1.868,-4.415c1.678,-4.144 3.114,-8.383 4.301,-12.693c0.496,-1.806 2.361,-2.868 4.166,-2.371l0,0Zm-31.95,51.465c5.396,-5.669 10.205,-11.87 14.354,-18.508c0.642,-1.027 1.783,-1.634 2.993,-1.591c1.21,0.042 2.306,0.728 2.874,1.798c0.569,1.07 0.523,2.362 -0.119,3.389c-4.392,7.026 -9.482,13.589 -15.194,19.591c-0.834,0.882 -2.076,1.251 -3.256,0.966c-1.18,-0.284 -2.118,-1.179 -2.459,-2.344c-0.341,-1.166 -0.033,-2.425 0.807,-3.301Zm38.493,-85.952c0.048,0.898 -0.262,1.778 -0.863,2.447c-0.601,0.668 -1.443,1.071 -2.34,1.119c-0.061,0.003 -0.123,0.005 -0.184,0.005c-1.8,-0.002 -3.285,-1.412 -3.381,-3.211c-0.301,-5.582 -1.002,-11.136 -2.098,-16.618l-0.086,-0.422c-0.367,-1.836 0.823,-3.623 2.658,-3.99c1.835,-0.368 3.62,0.823 3.988,2.659l0.079,0.385c1.163,5.814 1.908,11.705 2.227,17.626Zm-88.483,120.287c0.228,0.87 0.101,1.795 -0.354,2.571c-0.454,0.776 -1.198,1.339 -2.067,1.566c-2.309,0.605 -4.65,1.144 -7.023,1.618c-2.294,0.46 -4.586,0.852 -6.876,1.177c-1.2,0.175 -2.403,-0.305 -3.153,-1.259c-0.75,-0.954 -0.932,-2.237 -0.479,-3.362c0.454,-1.126 1.474,-1.924 2.676,-2.091c2.164,-0.309 4.332,-0.681 6.503,-1.114c2.244,-0.449 4.456,-0.958 6.637,-1.528c0.87,-0.228 1.794,-0.101 2.57,0.353c0.776,0.454 1.339,1.199 1.566,2.069Zm47.232,-22.277c-4.437,3.91 -9.153,7.492 -14.109,10.718c-1.569,1.018 -3.666,0.572 -4.685,-0.997c-1.019,-1.569 -0.575,-3.667 0.992,-4.688c4.679,-3.047 9.131,-6.43 13.32,-10.123c0.909,-0.801 2.176,-1.056 3.323,-0.669c1.148,0.387 2.002,1.357 2.241,2.545c0.239,1.188 -0.174,2.413 -1.082,3.214l0,0Zm-119.574,24.03c-5.603,-1.897 -11.061,-4.197 -16.333,-6.882c-1.667,-0.849 -2.331,-2.891 -1.482,-4.559c0.849,-1.669 2.889,-2.333 4.557,-1.484c4.98,2.537 10.136,4.709 15.429,6.502c1.158,0.379 2.023,1.351 2.266,2.546c0.243,1.194 -0.174,2.427 -1.091,3.229c-0.918,0.802 -2.195,1.05 -3.346,0.648l0,0Zm140.573,-170.135c-0.575,-1.069 -0.535,-2.363 0.105,-3.394c0.639,-1.031 1.78,-1.641 2.992,-1.601c1.212,0.04 2.31,0.725 2.88,1.796c3.906,7.309 7.056,14.998 9.401,22.947c0.342,1.161 0.04,2.418 -0.794,3.296c-0.834,0.878 -2.073,1.244 -3.25,0.96c-1.177,-0.284 -2.114,-1.174 -2.457,-2.336c-2.215,-7.506 -5.189,-14.766 -8.877,-21.668Zm-234.822,18.402c-0.437,-0.785 -0.547,-1.711 -0.306,-2.576c2.281,-7.785 5.218,-15.362 8.779,-22.65c0.851,-1.653 2.854,-2.341 4.54,-1.56c1.679,0.83 2.375,2.858 1.559,4.544c-3.413,6.926 -6.203,14.143 -8.337,21.564c-0.444,1.445 -1.775,2.433 -3.286,2.441c-0.309,-0.012 -0.616,-0.058 -0.915,-0.136c-0.863,-0.259 -1.592,-0.842 -2.034,-1.627l0,0Zm175.65,-96.362c1.594,0.502 2.583,2.092 2.329,3.744c-0.254,1.652 -1.676,2.87 -3.346,2.869c-0.355,0.007 -0.709,-0.039 -1.051,-0.136c-0.85,-0.289 -1.555,-0.897 -1.966,-1.695c-0.419,-0.795 -0.492,-1.727 -0.202,-2.578c0.568,-1.774 2.459,-2.758 4.236,-2.204Zm-151.52,218.56c-0.563,-0.702 -0.82,-1.601 -0.711,-2.495c0.108,-0.893 0.572,-1.705 1.287,-2.252c1.475,-1.103 3.555,-0.865 4.744,0.543c4.78,6.064 10.087,11.692 15.861,16.818c0.67,0.598 1.075,1.438 1.125,2.334c0.051,0.897 -0.257,1.777 -0.855,2.447c-0.638,0.738 -1.567,1.159 -2.542,1.152c-0.823,-0.002 -1.618,-0.303 -2.236,-0.848c-6.062,-5.402 -11.641,-11.325 -16.673,-17.699l0,0Zm46.767,34.348c0.832,-1.675 2.855,-2.371 4.541,-1.561c2.948,1.425 5.998,2.781 9.048,4.001c1.512,0.601 2.385,2.192 2.079,3.791c-0.306,1.599 -1.705,2.755 -3.332,2.754c-0.428,-0.01 -0.852,-0.091 -1.254,-0.239c-3.22,-1.288 -6.439,-2.711 -9.523,-4.238c-1.668,-0.82 -2.364,-2.832 -1.559,-4.508Zm-7.354,-236.938c-0.912,-1.629 -0.337,-3.69 1.288,-4.611c3.049,-1.695 6.167,-3.322 9.251,-4.781c1.697,-0.739 3.675,-0.025 4.508,1.628c0.388,0.813 0.434,1.747 0.128,2.594c-0.306,0.848 -0.937,1.537 -1.755,1.915c-2.914,1.391 -5.863,2.918 -8.811,4.545c-0.503,0.295 -1.077,0.447 -1.66,0.44c-1.225,0.004 -2.355,-0.658 -2.949,-1.73Zm-59.95,166.548l0,-0.068c-0.335,-0.831 -0.311,-1.764 0.067,-2.576c0.355,-0.825 1.026,-1.473 1.864,-1.798c1.757,-0.612 3.687,0.249 4.405,1.967c0.653,1.75 -0.223,3.701 -1.965,4.374c-0.39,0.15 -0.803,0.23 -1.221,0.236c-1.378,-0.03 -2.611,-0.866 -3.15,-2.135Zm104.65,-185.873c0.529,-0.729 1.318,-1.227 2.203,-1.391c7.782,-1.311 15.663,-1.946 23.554,-1.899l0.677,0c1.867,0.028 3.364,1.556 3.355,3.424c-0.009,1.869 -1.521,3.382 -3.388,3.392c-0.475,-0.035 -0.882,-0.035 -1.288,-0.035c-7.302,-0.003 -14.592,0.609 -21.791,1.831c-0.18,0.029 -0.362,0.041 -0.543,0.035c-1.667,0.005 -3.089,-1.203 -3.354,-2.849c-0.136,-0.879 0.07,-1.777 0.575,-2.508Zm-75.947,45.129c-0.661,-0.609 -1.051,-1.457 -1.083,-2.355c-0.032,-0.899 0.298,-1.773 0.914,-2.426c1.308,-1.32 3.416,-1.394 4.812,-0.169c0.637,0.63 1.012,1.477 1.051,2.372c0.019,0.885 -0.296,1.744 -0.882,2.408c-0.033,0 -0.033,0 -0.033,0.034c-0.644,0.677 -1.539,1.058 -2.474,1.052c-0.857,0.001 -1.682,-0.327 -2.305,-0.916Zm-37.719,100.159c-0.203,-3.29 -0.339,-6.545 -0.339,-9.664l0,-0.78c0.02,-1.858 1.531,-3.355 3.389,-3.357c0.902,-0.009 1.769,0.345 2.406,0.983c0.638,0.638 0.992,1.506 0.983,2.408l0,0.747c0,3.084 0.136,6.17 0.339,9.188c0.121,1.863 -1.29,3.472 -3.152,3.594c-0.076,0.027 -0.156,0.039 -0.237,0.033c-1.775,-0.014 -3.246,-1.382 -3.389,-3.152l0,0Zm259.629,58.826c-0.237,0.407 -0.441,0.78 -0.644,1.154c-0.61,1.052 -1.734,1.698 -2.949,1.695c-0.592,-0.01 -1.173,-0.161 -1.694,-0.442c-1.602,-0.94 -2.158,-2.989 -1.253,-4.611l0,-0.033l0.202,-0.306c0.135,-0.237 0.271,-0.508 0.407,-0.745c0,-0.009 0.003,-0.018 0.01,-0.025c0.006,-0.006 0.015,-0.01 0.025,-0.01c0.953,-1.581 2.973,-2.146 4.608,-1.288c1.623,0.922 2.198,2.981 1.288,4.611Zm-7.118,-148.068c4.651,6.645 8.7,13.691 12.1,21.056c0.785,1.695 0.059,3.706 -1.627,4.509c-0.448,0.198 -0.932,0.302 -1.423,0.305c-1.322,-0.001 -2.524,-0.767 -3.084,-1.965c-3.252,-7.002 -7.107,-13.707 -11.522,-20.039c-0.509,-0.743 -0.715,-1.653 -0.576,-2.543c0.168,-0.884 0.68,-1.665 1.423,-2.171c1.542,-1.03 3.623,-0.656 4.709,0.848Zm-19.248,176.923c0.628,0.653 0.959,1.536 0.915,2.44c-0.023,0.897 -0.416,1.744 -1.085,2.34c-2.507,2.341 -5.152,4.645 -7.895,6.816c-0.599,0.474 -1.338,0.736 -2.102,0.746c-1.448,0.004 -2.741,-0.909 -3.222,-2.276c-0.481,-1.367 -0.044,-2.889 1.088,-3.793c2.609,-2.069 5.116,-4.238 7.489,-6.409l0.033,-0.035c1.379,-1.241 3.493,-1.165 4.779,0.171Zm-105.397,41.4c-0.896,-0.064 -1.729,-0.483 -2.315,-1.164c-0.585,-0.681 -0.874,-1.568 -0.803,-2.464c0.165,-1.851 1.772,-3.234 3.626,-3.121l0.035,0c1.81,0.163 3.171,1.721 3.089,3.538c-0.082,1.816 -1.578,3.245 -3.395,3.244c-0.081,0.005 -0.161,-0.006 -0.237,-0.034l0,0.001Zm139.219,-107.28c0.745,-3.119 1.423,-6.374 1.966,-9.664l0,-0.033c0.317,-1.839 2.056,-3.079 3.897,-2.78c0.893,0.119 1.694,0.612 2.202,1.356c0.532,0.721 0.752,1.624 0.611,2.508c-0.576,3.459 -1.289,6.884 -2.102,10.24c-0.29,1.175 -1.185,2.106 -2.348,2.441c-1.162,0.336 -2.415,0.026 -3.287,-0.813c-0.872,-0.84 -1.23,-2.08 -0.939,-3.255l0,0Zm2.507,-49.197c-0.252,-1.864 1.053,-3.58 2.916,-3.833c1.853,-0.253 3.56,1.045 3.812,2.899c0.253,1.854 -1.044,3.562 -2.897,3.814c-0.157,0.029 -0.316,0.041 -0.475,0.035c-1.683,-0.014 -3.106,-1.25 -3.356,-2.915Zm-77.2,146.068c-7.476,3.127 -15.209,5.6 -23.112,7.39c-0.245,0.056 -0.496,0.079 -0.747,0.068c-1.577,0.003 -2.951,-1.076 -3.321,-2.611c-0.197,-0.883 -0.039,-1.808 0.44,-2.576c0.481,-0.766 1.251,-1.304 2.135,-1.491c7.521,-1.714 14.88,-4.073 21.995,-7.053c1.732,-0.692 3.699,0.119 4.44,1.831c0.715,1.732 -0.103,3.717 -1.83,4.442Zm25.892,-242.125c2.846,2 5.66,4.103 8.302,6.273c0.703,0.556 1.145,1.378 1.221,2.271c0.106,0.953 -0.2,1.906 -0.841,2.619c-0.641,0.713 -1.556,1.117 -2.514,1.111c-0.779,0.018 -1.537,-0.247 -2.135,-0.746c-2.542,-2.068 -5.219,-4.07 -7.931,-5.967c-1.52,-1.077 -1.897,-3.174 -0.848,-4.713c1.101,-1.508 3.192,-1.881 4.746,-0.848Zm-119.257,263.79c-0.718,-1.167 -0.657,-2.652 0.155,-3.756c0.812,-1.103 2.212,-1.602 3.538,-1.262c7.869,1.936 15.882,3.229 23.96,3.865c0.896,0.073 1.726,0.5 2.305,1.188c0.579,0.688 0.86,1.579 0.779,2.474c-0.142,1.753 -1.599,3.106 -3.356,3.12c-0.091,0.008 -0.183,-0.004 -0.27,-0.035c-8.443,-0.671 -16.818,-2.02 -25.045,-4.035c-0.866,-0.228 -1.609,-0.788 -2.066,-1.559Zm-39.923,-280.099c-0.468,-0.775 -0.602,-1.706 -0.372,-2.581c0.23,-0.875 0.804,-1.62 1.591,-2.065c1.186,-0.675 2.661,-0.577 3.747,0.251c1.086,0.827 1.572,2.224 1.236,3.547c-0.243,0.871 -0.814,1.612 -1.594,2.068l-0.033,0c-0.503,0.296 -1.078,0.448 -1.661,0.44c-1.196,0.001 -2.304,-0.631 -2.914,-1.66Zm158.806,260.637c0.466,0.775 0.588,1.708 0.339,2.577c-0.216,0.873 -0.779,1.62 -1.558,2.067c-0.514,0.301 -1.1,0.454 -1.695,0.442c-1.055,0.018 -2.056,-0.463 -2.702,-1.297c-0.647,-0.833 -0.863,-1.923 -0.584,-2.941c0.232,-0.875 0.806,-1.62 1.592,-2.069c1.614,-0.9 3.651,-0.36 4.608,1.221Zm-153.655,-1.086c1.337,0.765 1.992,2.335 1.594,3.824c-0.398,1.489 -1.748,2.522 -3.288,2.517c-0.592,-0.009 -1.173,-0.16 -1.695,-0.44c-0.779,-0.457 -1.35,-1.198 -1.593,-2.068c-0.219,-0.875 -0.085,-1.801 0.373,-2.578c0.961,-1.574 2.983,-2.124 4.609,-1.255Zm147.251,-263.417c0.963,-1.593 3.008,-2.146 4.642,-1.255c1.315,0.772 1.953,2.328 1.557,3.801c-0.395,1.473 -1.727,2.499 -3.252,2.507c-0.594,0.011 -1.18,-0.142 -1.694,-0.44c-1.616,-0.931 -2.176,-2.993 -1.253,-4.613Zm-32.534,281.321c0.208,0.879 0.062,1.804 -0.407,2.576c-0.443,0.778 -1.194,1.332 -2.067,1.526c-3.457,0.881 -7.016,1.628 -10.642,2.272c-0.19,0.037 -0.382,0.06 -0.576,0.068c-1.761,0.003 -3.234,-1.34 -3.392,-3.095c-0.159,-1.755 1.048,-3.341 2.782,-3.654c3.423,-0.609 6.845,-1.321 10.201,-2.168c1.809,-0.409 3.619,0.683 4.101,2.475Zm-80.963,-294.375c-0.205,-0.864 -0.072,-1.774 0.372,-2.543c0.463,-0.782 1.22,-1.344 2.102,-1.56c3.424,-0.88 6.981,-1.627 10.607,-2.271c0.886,-0.163 1.801,0.035 2.539,0.551c0.739,0.516 1.241,1.307 1.393,2.195c0.164,0.876 -0.031,1.781 -0.543,2.51c-0.499,0.744 -1.284,1.247 -2.168,1.389c-3.424,0.611 -6.846,1.356 -10.167,2.204c-0.277,0.067 -0.561,0.102 -0.847,0.103c-1.56,0.005 -2.92,-1.061 -3.288,-2.578Zm196.527,146.51c0.006,0.114 -0.006,0.228 -0.035,0.338c0.031,0.087 0.043,0.18 0.035,0.271l0,0.035c0,1.873 -1.517,3.391 -3.389,3.391c-1.872,0 -3.389,-1.518 -3.389,-3.391l0,-0.679c-0.009,-0.882 0.347,-1.728 0.983,-2.339c0.962,-0.984 2.423,-1.286 3.696,-0.764c1.273,0.521 2.103,1.762 2.099,3.138Zm-146.54,-149.255c-0.894,-1.038 -1.076,-2.513 -0.461,-3.738c0.616,-1.224 1.908,-1.958 3.274,-1.858c8.444,0.647 16.82,1.985 25.045,4.002c0.879,0.202 1.637,0.753 2.1,1.526c0.475,0.77 0.611,1.703 0.374,2.576c-0.212,0.875 -0.764,1.628 -1.534,2.093c-0.77,0.465 -1.694,0.603 -2.566,0.382c-7.862,-1.907 -15.863,-3.188 -23.927,-3.831c-0.892,-0.056 -1.724,-0.472 -2.305,-1.152Zm-128.205,245.582c1.443,-1.175 3.556,-0.995 4.779,0.407c2.203,2.611 4.541,5.221 6.982,7.697c1.293,1.36 1.248,3.51 -0.103,4.814c-0.623,0.614 -1.463,0.956 -2.338,0.95c-0.917,0.003 -1.796,-0.364 -2.439,-1.018c-2.474,-2.576 -4.948,-5.289 -7.286,-8.104c-1.198,-1.423 -1.016,-3.548 0.405,-4.746l0,0Zm253.428,-160.071c-0.393,-0.803 -0.454,-1.729 -0.17,-2.577c0.297,-0.859 0.934,-1.558 1.762,-1.933c1.687,-0.757 3.671,-0.055 4.508,1.594c3.637,7.648 6.663,15.573 9.048,23.7c0.243,0.865 0.134,1.792 -0.304,2.577c-0.408,0.8 -1.134,1.391 -1.999,1.628c-0.308,0.092 -0.629,0.138 -0.95,0.136c-1.507,0 -2.833,-0.995 -3.254,-2.442c-2.261,-7.783 -5.151,-15.369 -8.641,-22.683Zm13.013,103.177c0.867,0.234 1.602,0.81 2.036,1.596c0.435,0.786 0.532,1.715 0.269,2.574c-0.982,3.492 -2.101,6.95 -3.355,10.341c-0.479,1.347 -1.757,2.245 -3.186,2.238c-0.393,-0.001 -0.782,-0.07 -1.152,-0.203c-0.84,-0.295 -1.525,-0.919 -1.898,-1.729c-0.398,-0.815 -0.447,-1.758 -0.135,-2.611c1.186,-3.221 2.27,-6.544 3.22,-9.902c0.552,-1.774 2.409,-2.793 4.201,-2.304Zm-296.703,-38.484c0.006,1.211 -0.635,2.334 -1.68,2.944c-1.046,0.611 -2.338,0.618 -3.389,0.017c-1.052,-0.601 -1.703,-1.717 -1.709,-2.928c-0.009,-1.873 1.501,-3.398 3.372,-3.407c1.872,-0.009 3.397,1.501 3.406,3.374Zm256.003,-104.33c-0.643,-0.632 -0.988,-1.506 -0.95,-2.407c-0.003,-0.898 0.365,-1.757 1.017,-2.374c1.344,-1.286 3.471,-1.256 4.778,0.068c2.576,2.611 5.015,5.324 7.32,8.036c0.572,0.692 0.852,1.58 0.78,2.475c-0.055,0.901 -0.485,1.738 -1.187,2.306c-0.607,0.514 -1.374,0.801 -2.169,0.813c-1.009,0.005 -1.966,-0.443 -2.61,-1.22c-2.202,-2.611 -4.54,-5.187 -6.979,-7.697l0,0Zm20.502,187.976c0.743,0.506 1.255,1.287 1.423,2.171c0.169,0.886 -0.027,1.803 -0.543,2.543c-4.832,6.954 -10.203,13.518 -16.062,19.631c-0.639,0.661 -1.522,1.029 -2.441,1.017c-1.362,0.011 -2.596,-0.798 -3.129,-2.051c-0.534,-1.254 -0.262,-2.705 0.69,-3.679c5.612,-5.839 10.746,-12.121 15.351,-18.784c1.105,-1.476 3.162,-1.846 4.711,-0.848l0,0Zm-265.153,-15.021c-1.305,0.003 -2.494,-0.75 -3.05,-1.932c-3.639,-7.64 -6.642,-15.566 -8.98,-23.7c-0.268,-0.863 -0.174,-1.799 0.26,-2.591c0.435,-0.793 1.173,-1.375 2.045,-1.614c1.791,-0.48 3.643,0.537 4.201,2.307c2.227,7.789 5.107,15.377 8.608,22.683c0.366,0.823 0.415,1.753 0.136,2.611c-0.309,0.844 -0.944,1.528 -1.763,1.898c-0.45,0.231 -0.951,0.347 -1.457,0.338Zm10.167,-152.611c-1.525,-1.074 -1.902,-3.175 -0.848,-4.713c4.802,-6.979 10.163,-13.556 16.03,-19.665c1.313,-1.299 3.412,-1.345 4.779,-0.103c0.637,0.631 1.012,1.479 1.051,2.374c0.022,0.908 -0.32,1.787 -0.948,2.442c-5.613,5.84 -10.747,12.121 -15.353,18.784c-0.501,0.752 -1.283,1.269 -2.17,1.435c-0.887,0.166 -1.804,-0.034 -2.541,-0.554l0,0Zm-22.401,41.027c0.983,-3.458 2.102,-6.952 3.321,-10.342c0.668,-1.75 2.605,-2.651 4.372,-2.033c1.746,0.651 2.65,2.58 2.034,4.339c-1.187,3.187 -2.238,6.544 -3.221,9.9c-0.404,1.463 -1.735,2.476 -3.253,2.475c-0.309,-0.012 -0.616,-0.057 -0.915,-0.135c-1.8,-0.522 -2.844,-2.398 -2.338,-4.204Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
            </svg>
    </div>
    <div class="decoration-02 sr-only sr-only-focusable">
        <svg width="100%" height="100%" viewBox="0 0 102 114" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
              <g id="Group">
                  <path id="Shape0" d="M64.801,56.665c0,-7.5 -6.116,-13.6 -13.636,-13.6c-7.52,0 -13.636,6.1 -13.636,13.6c0,7.5 6.116,13.599 13.636,13.599c7.52,0 13.636,-6.099 13.636,-13.599Zm-13.636,9.066c-5.014,0 -9.091,-4.066 -9.091,-9.066c0,-5 4.077,-9.067 9.091,-9.067c5.013,0 9.091,4.067 9.091,9.067c0,5 -4.078,9.066 -9.091,9.066Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
                  <path id="Shape1" serif:id="Shape" d="M90.307,65.164c6.05,7.442 8.284,13.842 6.125,17.566c-2.191,3.788 -9.018,5.034 -18.722,3.425c-2.15,-0.356 -4.402,-0.875 -6.7,-1.482c1.05,-4.694 1.839,-9.821 2.323,-15.266c1.941,-1.357 3.84,-2.738 5.654,-4.159l-2.809,-3.563c-0.795,0.623 -1.625,1.233 -2.448,1.845c0.103,-2.251 0.162,-4.538 0.162,-6.865c0,-2.333 -0.059,-4.622 -0.166,-6.873c1.116,0.832 2.22,1.666 3.288,2.519l2.841,-3.541c-2.077,-1.659 -4.272,-3.268 -6.525,-4.846c-0.484,-5.446 -1.272,-10.571 -2.322,-15.268c2.3,-0.607 4.552,-1.126 6.7,-1.482c9.704,-1.611 16.533,-0.363 18.722,3.423c2.154,3.724 -0.075,10.122 -6.123,17.561l3.53,2.856c7.409,-9.109 9.727,-17.163 6.531,-22.682c-3.238,-5.596 -11.554,-7.59 -23.406,-5.628c-2.263,0.377 -4.632,0.921 -7.047,1.555c-4.062,-14.753 -10.878,-24.259 -18.75,-24.259c-6.466,0 -12.35,6.156 -16.563,17.335l4.252,1.596c3.452,-9.151 7.938,-14.398 12.311,-14.398c5.22,0 10.791,7.924 14.37,20.998c-4.65,1.469 -9.479,3.357 -14.37,5.625c-1.993,-0.922 -3.984,-1.811 -5.966,-2.613l-1.709,4.202c0.786,0.318 1.575,0.669 2.364,1.009c-2.021,1.043 -4.044,2.124 -6.055,3.282c-2.016,1.16 -3.968,2.369 -5.886,3.595c0.159,-1.353 0.327,-2.702 0.527,-4.023l-4.493,-0.68c-0.395,2.599 -0.693,5.274 -0.934,7.983c-4.427,3.096 -8.488,6.328 -12.095,9.619c-1.677,-1.682 -3.252,-3.368 -4.637,-5.045c-6.252,-7.58 -8.581,-14.099 -6.39,-17.886c1.904,-3.293 7.547,-4.703 15.486,-3.865l0.475,-4.508c-10.098,-1.058 -16.975,1.052 -19.9,6.106c-3.241,5.597 -0.818,13.777 6.816,23.033c1.457,1.764 3.109,3.534 4.866,5.3c-1.778,1.786 -3.448,3.576 -4.918,5.36l3.513,2.876c1.396,-1.695 2.989,-3.399 4.684,-5.102c3.607,3.291 7.668,6.524 12.095,9.62c0.241,2.708 0.537,5.383 0.935,7.985l4.493,-0.682c-0.2,-1.322 -0.369,-2.67 -0.53,-4.024c1.918,1.227 3.87,2.435 5.886,3.595c2.014,1.161 4.037,2.24 6.057,3.282c-0.789,0.338 -1.579,0.692 -2.366,1.009l1.709,4.202c1.982,-0.802 3.975,-1.688 5.966,-2.613c4.891,2.269 9.718,4.159 14.368,5.625c-3.57,13.074 -9.141,20.998 -14.361,20.998c-4.373,0 -8.861,-5.249 -12.316,-14.406l-4.252,1.595c4.216,11.184 10.1,17.344 16.568,17.344c7.872,0 14.688,-9.506 18.752,-24.259c2.416,0.637 4.784,1.181 7.047,1.557c2.975,0.494 5.728,0.737 8.23,0.737c7.477,0 12.75,-2.174 15.177,-6.367c3.195,-5.519 0.877,-13.577 -6.534,-22.686l-3.53,2.853Zm-23.683,-35.227c0.731,3.318 1.347,6.879 1.802,10.701c-1.923,-1.231 -3.88,-2.442 -5.895,-3.602c-2.016,-1.16 -4.046,-2.244 -6.078,-3.291c3.462,-1.491 6.862,-2.752 10.171,-3.808Zm-46.411,26.728c2.575,-2.335 5.375,-4.645 8.405,-6.895c-0.107,2.278 -0.18,4.571 -0.18,6.895c0,2.323 0.073,4.617 0.18,6.895c-3.03,-2.251 -5.83,-4.561 -8.405,-6.895Zm21.861,15.703c-3.027,-1.743 -5.941,-3.568 -8.722,-5.449c-0.246,-3.355 -0.369,-6.78 -0.369,-10.254c0,-3.475 0.123,-6.9 0.369,-10.254c2.781,-1.882 5.695,-3.706 8.722,-5.449c3.023,-1.741 6.059,-3.341 9.079,-4.803c3.041,1.469 6.084,3.064 9.103,4.803c3.013,1.736 5.922,3.551 8.709,5.437c0.24,3.289 0.381,6.707 0.381,10.266c0,3.554 -0.141,6.969 -0.381,10.256c-2.794,1.89 -5.698,3.713 -8.709,5.447c-3.019,1.738 -6.062,3.334 -9.103,4.802c-3.02,-1.462 -6.056,-3.062 -9.079,-4.802Zm14.377,7.219c2.032,-1.048 4.061,-2.131 6.077,-3.294c2.016,-1.16 3.971,-2.371 5.896,-3.601c-0.453,3.821 -1.071,7.382 -1.803,10.7c-3.306,-1.054 -6.709,-2.316 -10.17,-3.805Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
                  <path id="Shape2" serif:id="Shape" d="M8.961,85.382l-1.957,4.091c2.664,1.267 6.025,1.902 10.043,1.902c2.198,0 4.593,-0.19 7.18,-0.571l-0.666,-4.486c-6.309,0.934 -11.357,0.608 -14.6,-0.936Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
                  <path id="Shape3" serif:id="Shape" d="M32.983,33.999c3.759,0 6.818,-3.051 6.818,-6.8c0,-3.749 -3.059,-6.8 -6.818,-6.8c-3.759,0 -6.818,3.051 -6.818,6.8c0,3.749 3.059,6.8 6.818,6.8Zm0,-9.067c1.255,0 2.273,1.018 2.273,2.267c0,1.249 -1.018,2.267 -2.273,2.267c-1.254,0 -2.272,-1.018 -2.272,-2.267c0,-1.249 1.018,-2.267 2.272,-2.267Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
                  <path id="Shape4" serif:id="Shape" d="M85.255,49.865c-3.759,0 -6.818,3.051 -6.818,6.8c0,3.749 3.059,6.799 6.818,6.799c3.759,0 6.818,-3.05 6.818,-6.799c0,-3.749 -3.059,-6.8 -6.818,-6.8Zm0,9.066c-1.254,0 -2.273,-1.017 -2.273,-2.266c0,-1.249 1.019,-2.267 2.273,-2.267c1.255,0 2.273,1.018 2.273,2.267c0,1.249 -1.018,2.266 -2.273,2.266Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
                  <path id="Shape5" serif:id="Shape" d="M42.074,86.13c0,-3.749 -3.059,-6.8 -6.818,-6.8c-3.759,0 -6.818,3.051 -6.818,6.8c0,3.749 3.059,6.8 6.818,6.8c3.759,0 6.818,-3.051 6.818,-6.8Zm-9.091,0c0,-1.251 1.019,-2.266 2.273,-2.266c1.255,0 2.273,1.015 2.273,2.266c0,1.251 -1.018,2.267 -2.273,2.267c-1.254,0 -2.273,-1.016 -2.273,-2.267Z" style="fill:#f83e5a;fill-rule:nonzero;"/>
              </g>
            </svg>
    </div>
    <div class="container sr-only sr-only-focusable">
        <div class="row variable-gutters">
            <div class="col-md-<?php echo $colid; ?>">
                <div class="hero-title">
                    <div class="text-white font-weight-normal h4"><?php echo dsi_get_option("tipologia_scuola"); ?> </div>
                    <h1><span class="d-line d-xl-block"><?php echo dsi_get_option("nome_scuola"); ?></span> </h1>
                    <h2 class="text-white font-weight-normal h3"><?php echo dsi_get_option("luogo_scuola"); ?></h2>
                    <?php if($landing_url){ ?>
                        <a class="btn btn-sm btn-outline-white mt-4" href="<?php echo $landing_url; ?>" aria-label="Vai alla scuola"><?php _e("Vai alla scuola", "design_scuole_italia"); ?></a>
                    <?php } ?>

                </div><!-- /hero-title -->
            </div><!-- /col-md-6 -->
        </div><!-- /row -->
    </div><!-- /container -->
    <div class="hero-img d-none d-md-block" style="background-image: url('<?php echo $img_identita; ?>');"></div>
</section><!-- /section -->