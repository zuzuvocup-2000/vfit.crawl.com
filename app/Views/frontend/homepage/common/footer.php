<?php
    $footer_menu = get_menu(['keyword' => 'menu footer','language' => $language,'output' => 'array']);
?>
<?php $banner = get_slide(['keyword' => 'banner-footer' , 'language' => $language, ]) ?>
<?php if(isset($banner) && is_array($banner) && count($banner)){ ?>
    <div class="banner-panel">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-2-5">
                    <div class="banner-container">
                        <p class="bulk-banner-title"><?php echo $banner[0]['cat_title'] ?></p>
                        <p class="des"><?php echo strip_tags($banner[0]['cat_description']) ?></p>
                        <div class="button-group uk-flex uk-flex-middle">
                            <a href="" title="View more" class="button btn-submit get-started" name="create" value="">Get A Quote</a>
                            <a href="" title="View more" class="mc-ml-6 mc-text--link uk-flex uk-flex-middle">
                                <span>Learn more</span>
                                <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-ml-1 bulk-banner-pointer"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.845 5.47a.75.75 0 011.06 0l6 6a.75.75 0 010 1.06l-6 6a.75.75 0 11-1.06-1.06l5.47-5.47-5.47-5.47a.75.75 0 010-1.06z" fill="currentColor"></path><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" d="M17.75 12.023H6.25"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="uk-width-large-3-5">
                    <div class="image img-cover">
                        <?php echo render_img(['src' => $banner[0]['image']]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<footer class="footer">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium">
            <?php if(isset($footer_menu['data']) && is_array($footer_menu['data']) && count($footer_menu['data'])){
                foreach ($footer_menu['data'] as $key => $value) {
             ?>
                <div class="uk-width-large-1-4">
                    <div class="footer-item">
                        <div class="heading"><?php echo $value['title'] ?></div>
                        <?php if(isset($value['children']) && is_array($value['children']) && count($value['children'])){
                         ?>
                            <ul class="uk-list uk-clearfix">
                                <?php 
                                    foreach ($value['children'] as $valueChild) {
                                 ?>
                                    <li><a href="<?php echo $valueChild['canonical'] ?>" title="<?php echo $valueChild['title'] ?>"><?php echo $valueChild['title'] ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                </div>
            <?php }} ?>
            <div class="uk-width-large-1-4">
                <div class="footer-item">
                    <div class="heading">Social</div>
                    <ul class="uk-list uk-clearfix">
                        <li><a href="<?php echo $general['social_twitter'] ?>" title="Twiter" class="social-item "><svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-opacity--muted mc-mr-4"><path d="M8.654 19c6.793 0 10.51-5.388 10.51-10.052 0-.152 0-.303-.008-.455A7.351 7.351 0 0021 6.66a7.752 7.752 0 01-2.125.558 3.588 3.588 0 001.628-1.956 7.553 7.553 0 01-2.348.854A3.767 3.767 0 0015.46 5c-2.038 0-3.695 1.585-3.695 3.534 0 .276.036.545.094.807-3.069-.145-5.792-1.558-7.614-3.693a3.416 3.416 0 00-.497 1.777c0 1.227.656 2.308 1.642 2.942a3.865 3.865 0 01-1.67-.44v.047c0 1.71 1.274 3.142 2.96 3.466-.31.083-.634.124-.973.124-.237 0-.468-.02-.691-.062.468 1.405 1.837 2.425 3.45 2.453a7.624 7.624 0 01-4.588 1.516c-.296 0-.59-.014-.879-.049A10.856 10.856 0 008.654 19z" fill="currentColor"></path></svg>Twitter</a></li>
                        <li><a href="<?php echo $general['social_insta'] ?>" title="instagram" class="social-item ">
                            <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-opacity--muted mc-mr-4"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 4c-2.173 0-2.445.01-3.298.048-.852.039-1.433.174-1.942.372a3.921 3.921 0 00-1.417.923c-.445.444-.719.89-.923 1.417-.198.509-.333 1.09-.372 1.942C4.01 9.555 4 9.827 4 12s.01 2.445.048 3.298c.039.852.174 1.433.372 1.942.204.526.478.973.923 1.417.444.445.89.719 1.417.923.509.198 1.09.333 1.942.372C9.555 19.99 9.827 20 12 20s2.445-.01 3.298-.048c.852-.039 1.433-.174 1.942-.372a3.922 3.922 0 001.417-.923c.445-.445.719-.89.923-1.417.198-.509.333-1.09.372-1.942.039-.853.048-1.125.048-3.298s-.01-2.445-.048-3.298c-.039-.852-.174-1.433-.372-1.942a3.922 3.922 0 00-.923-1.417 3.921 3.921 0 00-1.417-.923c-.509-.198-1.09-.333-1.942-.372C14.445 4.01 14.173 4 12 4zm0 1.442c2.136 0 2.389.008 3.232.046.78.036 1.204.166 1.486.276.373.145.64.318.92.598.28.28.453.547.598.92.11.282.24.706.275 1.486.039.843.047 1.096.047 3.232s-.008 2.39-.047 3.233c-.035.78-.165 1.203-.275 1.485-.145.374-.319.64-.599.92-.28.28-.546.453-.92.599-.281.11-.705.24-1.485.275-.843.039-1.096.047-3.232.047-2.137 0-2.39-.008-3.233-.047-.78-.035-1.204-.166-1.486-.275a2.479 2.479 0 01-.92-.599 2.478 2.478 0 01-.598-.92c-.11-.282-.24-.705-.275-1.485-.039-.844-.047-1.097-.047-3.233s.008-2.389.047-3.232c.035-.78.165-1.204.275-1.486.145-.373.318-.64.598-.92.28-.28.547-.453.92-.598.282-.11.706-.24 1.486-.276.843-.038 1.096-.046 3.232-.046z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M16.27 8.69a.96.96 0 100-1.92.96.96 0 000 1.92zM9.332 12a2.667 2.667 0 105.334 0 2.667 2.667 0 00-5.334 0zm-1.44 0a4.108 4.108 0 118.216 0 4.108 4.108 0 01-8.216 0z" fill="currentColor"></path></svg>
                            Instagram</a>
                        </li>
                        <li>
                            <a href="<?php echo $general['social_facebook'] ?>" title="facebook" class="social-item ">
                                <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-opacity--muted mc-mr-4"><path d="M19.117 4H4.877A.883.883 0 004 4.883v14.24a.883.883 0 00.883.877h7.664v-6.187h-2.08V11.39h2.08V9.61c0-2.066 1.263-3.2 3.106-3.2a16.73 16.73 0 011.862.096v2.166h-1.28c-1 0-1.193.48-1.193 1.176v1.542h2.398l-.32 2.423h-2.08V20h4.077a.883.883 0 00.883-.883V4.877A.883.883 0 0019.117 4z" fill="currentColor"></path></svg>
                                Facebook
                            </a>
                        </li>
                        <li><a href="<?php echo $general['social_youtube'] ?>" title="youtube" class="social-item ">
                            <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-opacity--muted mc-mr-4"><path fill-rule="evenodd" clip-rule="evenodd" d="M19.857 5.489a2.48 2.48 0 011.733 1.767c.41 1.56.41 4.812.41 4.812s0 3.253-.41 4.812a2.48 2.48 0 01-1.733 1.768c-1.53.417-7.66.417-7.66.417s-6.133 0-7.662-.417a2.48 2.48 0 01-1.733-1.768c-.41-1.56-.41-4.812-.41-4.812s0-3.253.41-4.812A2.48 2.48 0 014.535 5.49c1.53-.418 7.661-.418 7.661-.418s6.132 0 7.66.418zm-4.543 6.58l-5.125 2.953V9.115l5.125 2.954z" fill="currentColor"></path></svg>
                            YouTube
                        </a></li>
                        <li><a href="<?php echo $general['social_link'] ?>" title="linkendin" class="social-item ">
                            <svg width="2em" height="2em" viewBox="0 0 24 24" fill="none" class="mc-icon--3 mc-opacity--muted mc-mr-4"><path fill-rule="evenodd" clip-rule="evenodd" d="M18.814 4H5.186C4.542 4 4 4.508 4 5.153v13.695C4 19.49 4.525 20 5.186 20h13.628c.66 0 1.186-.525 1.186-1.152V5.152C20 4.525 19.475 4 18.814 4zM8.767 9.979v7.633h-2.4V9.979h2.4zm-1.2-3.8c.771 0 1.388.61 1.388 1.374 0 .763-.617 1.374-1.388 1.374-.771 0-1.388-.61-1.388-1.374 0-.763.617-1.374 1.388-1.374zm4.929 3.828h-2.287v7.665h2.372V13.89c0-1 .186-1.966 1.423-1.966 1.22 0 1.236 1.136 1.236 2.017v3.714h2.372v-4.189c0-2.068-.44-3.645-2.846-3.645-1.152 0-1.914.644-2.236 1.238h-.034v-1.052z" fill="currentColor"></path></svg>
                            LinkedIn
                        </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="uk-width-large-1-4">
                <div class="footer-item">
                    <div class="heading">Download</div>

                </div>
            </div>
        </div>
    </div>
</footer>
