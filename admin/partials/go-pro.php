<?php
$icon = Quick_Chat_Buttons::get_svg_icon();
$prices = Quick_Chat_Buttons::get_plan_prices();
$features = Quick_Chat_Buttons::get_features_list();
$cartURL = "https://go.klaxon.app/checkout/?edd_action=add_to_cart&download_id=53&edd_options[price_id]=";
$pricePerMonth1 = round($prices['1_domain']['1_year']['price'] / 12, 1);
$pricePerMonth2 = round($prices['10_domain']['1_year']['price'] / 12, 1);
$pricePerMonth3 = round($prices['50_domain']['1_year']['price'] / 12, 1);
?>
<div class="price-top-section">
    <div class="container">
        <h2 class="plan-page-title"><?php esc_html_e("Upgrade to Pro", "quick-chat-buttons") ?> &#128081;</h2>
        <div class="plan-switcher">
            <div class="plan-switch active" data-plan="yearly-plan">
                <div class="plan-title"><?php esc_html_e("Yearly Plan", "quick-chat-buttons") ?></div>
                <div class="plan-sub-title"><?php esc_html_e("Updates and Support for 1 year", "quick-chat-buttons") ?></div>
            </div>
            <div class="plan-switch" data-plan="lifetime-plan">
                <div class="plan-title"><?php esc_html_e("Lifetime", "quick-chat-buttons") ?></div>
                <div class="plan-sub-title"><?php esc_html_e("Updates and Support for lifetime", "quick-chat-buttons") ?></div>
            </div>
        </div>
    </div>
</div>
<div class="desktop-view-table">
    <div class="price-middle-section">
        <div class="container">
            <div class="pricing-table yearly-plan" data-plan="yearly-plan">
                <div class="pricing-row pricing-head">
                    <div class="pricing-col col-1">

                    </div>
                    <div class="pricing-col col-2">
                        <div class="plan-head">
                            <div class="plan-name"><?php esc_html_e("Basic", "quick-chat-buttons") ?></div>
                            <div class="yearly-note">
                                <div class="plan-price">$<?php echo esc_attr($prices['1_domain']['1_year']['price']) ?><span class=""><?php esc_html_e("/year", "quick-chat-buttons") ?></span></div>
                                <div class="plan-update"><?php esc_html_e("Billed Annually", "quick-chat-buttons") ?></div>
                                <div class="plan-feature"><span><?php esc_html_e("Less than ", "quick-chat-buttons") ?><?php echo "$" . esc_attr($pricePerMonth1) ?><?php esc_html_e("/mo", "quick-chat-buttons") ?></span></div>
                                <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['1_domain']['1_year']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                            </div>
                            <div class="lifetime-note">
                                <div class="plan-price">$<?php echo esc_attr($prices['1_domain']['lifetime']['price']) ?><span class=""><?php esc_html_e("/lifetime", "quick-chat-buttons") ?></span></div>
                                <div class="plan-update"><?php esc_html_e("For Lifetime", "quick-chat-buttons") ?></div>
                                <div class="plan-feature"><span><?php esc_html_e("Lifetime Support", "quick-chat-buttons") ?></span></div>
                                <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['1_domain']['lifetime']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-col col-3">
                        <div class="plan-head">
                            <div class="plan-name"><?php esc_html_e("Pro", "quick-chat-buttons") ?></div>
                            <div class="yearly-note">
                                <div class="plan-price">$<?php echo esc_attr($prices['10_domain']['1_year']['price']) ?><span class="">/year</span></div>
                                <div class="plan-update"><?php esc_html_e("Billed Annually", "quick-chat-buttons") ?></div>
                                <div class="plan-feature"><span><?php esc_html_e("Less than ", "quick-chat-buttons") ?><?php echo "$" . esc_attr($pricePerMonth2) ?><?php esc_html_e("/mo", "quick-chat-buttons") ?></span></div>
                                <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['10_domain']['1_year']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                            </div>
                            <div class="lifetime-note">
                                <div class="plan-price">$<?php echo esc_attr($prices['10_domain']['lifetime']['price']) ?><span class=""><?php esc_html_e("/lifetime", "quick-chat-buttons") ?></span></div>
                                <div class="plan-update"><?php esc_html_e("For Lifetime", "quick-chat-buttons") ?></div>
                                <div class="plan-feature"><span><?php esc_html_e("Lifetime Support", "quick-chat-buttons") ?></span></div>
                                <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['10_domain']['lifetime']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                            </div>
                        </div>
                    </div>
                    <div class="pricing-col col-4">
                        <div class="plan-head">
                            <div class="plan-name"><?php esc_html_e("Enterprise", "quick-chat-buttons"); ?></div>
                            <div class="yearly-note">
                                <div class="plan-price">$<?php echo esc_attr($prices['50_domain']['1_year']['price']) ?><span class=""><?php esc_html_e("/year", "quick-chat-buttons") ?></span></div>
                                <div class="plan-update"><?php esc_html_e("Billed Annually", "quick-chat-buttons") ?></div>
                                <div class="plan-feature"><span><?php esc_html_e("Less than ", "quick-chat-buttons") ?><?php echo "$" . esc_attr($pricePerMonth3) ?><?php esc_html_e("/mo", "quick-chat-buttons") ?></span></div>
                                <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['50_domain']['1_year']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                            </div>
                            <div class="lifetime-note">
                                <div class="plan-price">$<?php echo esc_attr($prices['50_domain']['lifetime']['price']) ?><span class=""><?php esc_html_e("/lifetime", "quick-chat-buttons") ?></span></div>
                                <div class="plan-update"><?php esc_html_e("For Lifetime", "quick-chat-buttons") ?></div>
                                <div class="plan-feature"><span><?php esc_html_e("Lifetime Support", "quick-chat-buttons") ?></span></div>
                                <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['50_domain']['lifetime']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pricing-row">
                    <div class="pricing-col col-1">
                        <div class="feature-info"><?php esc_html_e("Domains", "quick-chat-buttons") ?></div>
                        <span class="kl-price-tooltip">
                            <span class="kl-price-text"><?php esc_html_e("Use quick chat buttons on listed number of domains", "quick-chat-buttons") ?></span>
                            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                        </span>
                    </div>
                    <div class="pricing-col col-2">1</div>
                    <div class="pricing-col col-3">10</div>
                    <div class="pricing-col col-4">50</div>
                </div>
                <?php foreach ($features as $feature) { ?>
                <div class="pricing-row">
                    <div class="pricing-col col-1">
                        <?php echo esc_attr($feature['text']) ?>
                        <span class="kl-price-tooltip">
                            <span class="kl-price-text"><?php echo esc_attr($feature['tooltip']) ?></span>
                            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                        </span>
                    </div>
                    <div class="pricing-col col-2 col-yes"><?php echo $icon['check'] ?></div>
                    <div class="pricing-col col-3 col-yes"><?php echo $icon['check'] ?></div>
                    <div class="pricing-col col-3 col-yes"><?php echo $icon['check'] ?></div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="mobile-view-table">
    <div class="price-middle-section">
        <div class="container">
            <div class="pricing-tables yearly-plan" data-plan="yearly-plan">
                <div class="price-table">
                    <div class="plan-head">
                        <div class="plan-name"><?php esc_html_e("Basic", "quick-chat-buttons") ?></div>
                        <div class="yearly-note">
                            <div class="plan-price">$<?php echo esc_attr($prices['1_domain']['1_year']['price']) ?><span class=""><?php esc_html_e("/year", "quick-chat-buttons") ?></span></div>
                            <div class="plan-update"><?php esc_html_e("Billed Annually", "quick-chat-buttons") ?></div>
                            <div class="plan-feature"><span><?php esc_html_e("Less than ", "quick-chat-buttons") ?><?php echo "$" . esc_attr($pricePerMonth1) ?><?php esc_html_e("/mo", "quick-chat-buttons") ?></span></div>
                            <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['1_domain']['1_year']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                        </div>
                        <div class="lifetime-note">
                            <div class="plan-price">$<?php echo esc_attr($prices['1_domain']['lifetime']['price']) ?><span class=""><?php esc_html_e("/lifetime", "quick-chat-buttons") ?></span></div>
                            <div class="plan-update"><?php esc_html_e("For Lifetime", "quick-chat-buttons") ?></div>
                            <div class="plan-feature"><span><?php esc_html_e("Lifetime Support", "quick-chat-buttons") ?></span></div>
                            <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['1_domain']['lifetime']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                        </div>
                    </div>
                    <div class="pricing-col">
                        <span class="feature-text"><?php esc_html_e("1 Domain", "quick-chat-buttons") ?></span>
                        <span class="kl-price-tooltip">
                            <span class="kl-price-text"><?php esc_html_e("Use quick chat buttons on 1 domain", "quick-chat-buttons") ?></span>
                            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                        </span>
                    </div>
                    <?php foreach ($features as $feature) { ?>
                        <div class="pricing-col">
                            <span class="feature-text">
                                <?php echo esc_attr($feature['text']) ?>
                            </span>
                            <span class="kl-price-tooltip">
                                <span class="kl-price-text"><?php echo esc_attr($feature['tooltip']) ?></span>
                                <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                            </span>
                        </div>
                    <?php } ?>
                </div>

                <div class="price-table">
                    <div class="plan-head">
                        <div class="plan-name"><?php esc_html_e("Pro", "quick-chat-buttons") ?></div>
                        <div class="yearly-note">
                            <div class="plan-price">$<?php echo esc_attr($prices['10_domain']['1_year']['price']) ?><span class="">/year</span></div>
                            <div class="plan-update"><?php esc_html_e("Billed Annually", "quick-chat-buttons") ?></div>
                            <div class="plan-feature"><span><?php esc_html_e("Less than ", "quick-chat-buttons") ?><?php echo "$" . esc_attr($pricePerMonth2) ?><?php esc_html_e("/mo", "quick-chat-buttons") ?></span></div>
                            <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['10_domain']['1_year']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                        </div>
                        <div class="lifetime-note">
                            <div class="plan-price">$<?php echo esc_attr($prices['10_domain']['lifetime']['price']) ?><span class=""><?php esc_html_e("/lifetime", "quick-chat-buttons") ?></span></div>
                            <div class="plan-update"><?php esc_html_e("For Lifetime", "quick-chat-buttons") ?></div>
                            <div class="plan-feature"><span><?php esc_html_e("Lifetime Support", "quick-chat-buttons") ?></span></div>
                            <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['10_domain']['lifetime']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                        </div>
                    </div>
                    <div class="pricing-col">
                        <span class="feature-text"><?php esc_html_e("10 Domains", "quick-chat-buttons") ?></span>
                        <span class="kl-price-tooltip">
                            <span class="kl-price-text"><?php esc_html_e("Use quick chat buttons on 10 domains", "quick-chat-buttons") ?></span>
                            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                        </span>
                    </div>
                    <?php foreach ($features as $feature) { ?>
                        <div class="pricing-col">
                            <span class="feature-text">
                                <?php echo esc_attr($feature['text']) ?>
                            </span>
                            <span class="kl-price-tooltip">
                                <span class="kl-price-text"><?php echo esc_attr($feature['tooltip']) ?></span>
                                <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                            </span>
                        </div>
                    <?php } ?>
                </div>

                <div class="price-table">
                    <div class="plan-head">
                        <div class="plan-name"><?php esc_html_e("Enterprise", "quick-chat-buttons"); ?></div>
                        <div class="yearly-note">
                            <div class="plan-price">$<?php echo esc_attr($prices['50_domain']['1_year']['price']) ?><span class=""><?php esc_html_e("/year", "quick-chat-buttons") ?></span></div>
                            <div class="plan-update"><?php esc_html_e("Billed Annually", "quick-chat-buttons") ?></div>
                            <div class="plan-feature"><span><?php esc_html_e("Less than ", "quick-chat-buttons") ?><?php echo "$" . esc_attr($pricePerMonth3) ?><?php esc_html_e("/mo", "quick-chat-buttons") ?></span></div>
                            <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['50_domain']['1_year']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                        </div>
                        <div class="lifetime-note">
                            <div class="plan-price">$<?php echo esc_attr($prices['50_domain']['lifetime']['price']) ?><span class=""><?php esc_html_e("/lifetime", "quick-chat-buttons") ?></span></div>
                            <div class="plan-update"><?php esc_html_e("For Lifetime", "quick-chat-buttons") ?></div>
                            <div class="plan-feature"><span><?php esc_html_e("Lifetime Support", "quick-chat-buttons") ?></span></div>
                            <div class="plan-button"><a href="<?php echo esc_attr($cartURL).esc_attr($prices['50_domain']['lifetime']['id']) ?>" target="_blank"><?php esc_html_e("Buy Now", "quick-chat-buttons") ?></a></div>
                        </div>
                    </div>
                    <div class="pricing-col">
                        <span class="feature-text"><?php esc_html_e("50 Domains", "quick-chat-buttons") ?></span>
                        <span class="kl-price-tooltip">
                            <span class="kl-price-text"><?php esc_html_e("Use quick chat buttons on 50 domains", "quick-chat-buttons") ?></span>
                            <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                        </span>
                    </div>
                    <?php foreach ($features as $feature) { ?>
                        <div class="pricing-col">
                            <span class="feature-text">
                                <?php echo esc_attr($feature['text']) ?>
                            </span>
                            <span class="kl-price-tooltip">
                                <span class="kl-price-text"><?php echo esc_attr($feature['tooltip']) ?></span>
                                <span class="tooltip-icon"><?php echo $icon['help'] ?></span>
                            </span>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
