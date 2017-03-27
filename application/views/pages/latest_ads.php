<div id="items">
    <div class="container">
        <h2 class="blue">Latest Ads</h2>
        <div class="item-box">
            <?php if(count($ads) > 0): ?>
                <ul>
                    <?php foreach ($ads as $ad): 
                        $url = site_url('products/view/'.$ad['unique_id'].'/'.title_url($ad['title']));
                       // $url = site_url('products/view/'.$ad['unique_id']);
                    ?>
                        <li>
                            <a href="<?=$url?>">
                                <div class="table-display">
                                    <div class="cell-display">
                                         <img src="<?= base_url() ?>includes/uploads/thumbnails/<?=$ad['primary_photo']?>" alt="" class="img-responsive product-img">
                                    </div>
                                </div>
                            </a>
                            <h3><a href="<?=$url?>" title="<?=$ad['title']?>"><?=character_limiter($ad['title'],60)?></a></h3>
                            <p class="item-desc"><?=character_limiter($ad['description'], 200)?></p>
                            <span class="item-price red">P <?=number_format($ad['price'], 2)?></span>
                            <span class="item-info"> | <?= str_replace("_", " ", $ad['condition'])?> Size <?=$ad['size']?></span>
                            <!--span class="item-address"><?=$ad['location']?></span-->
                        </li>
                        
                    <?php endforeach; ?>
                </ul>
                <div class="clearfix"></div>
            <?php endif; ?>
            
        </div>
    </div>
</div>