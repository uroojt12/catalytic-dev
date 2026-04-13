<main>
    <section class="inventory_new marin_page">
        <div class="contain">
            <div class="inner">
                <form action="<?= base_url('account/add_user_margin') ?>" method="POST" class="frmAjax" id="frmMargin">
                    <h3>Adjust Your Margin</h3>
                    <h5>Use the slider below to set your profit margin.</h5>
                    <p>A 10% margin displays the value 10% lower than the original price</p>
                    <div class="txtGrp">
                        <label for="">Margin %</label>
                        <div class="inner_block">
                            <div class="first_value">
                                <p>0</p>
                            </div>
                            <!-- <div class="example"></div> -->
                            <input type="range" name="mem_margin" id="mem_margin" min="0" max="100" value="<?= !empty($member->mem_margin) ? $member->mem_margin : '0' ?>" class="fullness-range" style="width: 88%;" oninput="updateMarginSliderValue(this.value)">
                            <div class="last_value">
                                <p>100</p>
                            </div>
                        </div>
                    </div>

                    <div class="margin_percentage">
                        <h3><span id="user_margin_percentage"><?= !empty($member->mem_margin) ? $member->mem_margin : '0' ?></span>%</h3>
                        <p>Margin Percentage</p>
                    </div>
                    <div class="cta">
                        <button type="submit" class="webBtn">Save</button>
                    </div>

                </form>
            </div>
        </div>
    </section>
</main>
