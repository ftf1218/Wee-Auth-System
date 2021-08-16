<?
	/**
	* GitHub页面
	*
	* @package custom
	*/
if (defined('HEADNAV')){ $headnav = HEADNAV; }
if (defined('CAROUSEL')){ $carousel = CAROUSEL; }
if (defined('SLIST')){ $list = SLIST; }
    
    
    if ($githubUser == "" || $githubUser == null){
        $githubUser = 'wibus-wee';
      }
        $file = curl_get("https://api.github.com/users/$githubUser");
        // echo $file;
        $json = json_decode($file);
        $login = $json->login;
        $avatar = $json->avatar;
        $name = $json->name;
        if ($name == 'null') {
          $name = $githubUser;
        }
        $bio = $json->bio;
        $avatar_url = $json->avatar_url;
        $file = curl_get("https://api.github.com/users/$githubUser/repos");
        $json = json_decode($file);


      $this->need('header.php');?>
<main id='main'>
    <?$this->need($headnav);?>
    <div class="page">
            <div class="wrapper-inner">
                <div class="primary">
                    <div class="view">
                        <img class="item" src="<?echo $avatar_url;?>">
                    </div>
                    <span class="name"><?echo $name;?></span><span class="login"><?echo $login;?></span><span class="bio-api"><?echo $bio;?></span>
                </div>
                <div class="sub-i0">
                    <?

  foreach ($json as $item) {
    $body = '<div class="view-i0" style="background-color: rgb('.mt_rand(50, 255).', '.mt_rand(50, 255).', '.mt_rand(50, 255).')" >';
    $url = $item->html_url;
    $name = $item->name;
    $description = $item->description;
    // $language = $item->language;
    $body .= '<span class="repo-name-2">'.$name.'</span><span class="description">'.$description.'</span><a target="_blank" class="tag" href="'.$url.'">访问</a><div class="mask"></div>';
    // echo $url."\n";
    // echo $language."\n";
    $body .= '</div>';
    echo $body;
}

?>
                </div>
            </div>
            <style>
img{
    max-width: none;;
}
..header-container{
  padding-bottom: 0;
}
.page {
  display: flex;
  position: relative;
  align-items: flex-start;
  flex-direction: column;
  width: auto;
  height: auto;
  /* font-weight: 600; */
}

.repo-name-wrapper-i0 {
  display: flex;
  position: absolute;
  top: 948px;
  left: 502px;
  align-items: center;
  flex-direction: row;
  border-width: 1px;
  border-style: solid;
  border-radius: 19px;
  border-color: #979797;
  background-color: #435676;
  width: 381px;
  height: 225px;
  line-height: 40px;
  white-space: pre;
}

.repo-name {
  position: absolute;
  top: 42px;
  left: 112px;
  color: #ffffff;
  font-size: 28px;
}

.repo-name-wrapper-i1 {
  box-sizing: border-box;
  display: flex;
  position: absolute;
  top: 948px;
  right: 116px;
  align-items: flex-start;
  flex-direction: row;
  border-width: 1px;
  border-style: solid;
  border-radius: 19px;
  border-color: #979797;
  background-color: #5d5b5b;
  padding-right: 111px;
  padding-left: 112px;
  height: 225px;
  line-height: 40px;
  white-space: pre;
}

.repo-name-1 {
  margin-top: 36px;
  color: #ffffff;
  font-size: 28px;
}

.wrapper-inner {
  display: flex;
  position: relative;
  align-items: flex-start;
  align-self: center;
  flex-direction: row;
  margin-top: 78px;
  padding: 64px;
}

.primary {
  display: flex;
  align-items: flex-start;
  flex-direction: column;
  /* margin-right: 100px; */
  font-weight: 400;
  top: 45px;
  position: sticky;
}

.view {
  display: flex;
  position: relative;
  align-items: flex-start;
  flex-direction: row;
  justify-content: center;
}


.item {
  position: relative;
  width: 268px;
  height: 263px;
}

.name {
  position: relative;
  margin-top: 27px;
  margin-left: 17px;
  max-width: 251px;
  height: 49px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 49px;
  white-space: nowrap;
  color: #781212;
  font-size: 35px;
  font-weight: 600;
}

.login {
  position: relative;
  margin-left: 17px;
  max-width: 251px;
  height: 36px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 36px;
  white-space: nowrap;
  color: #758390;
  font-size: 25px;
  font-weight: 400;
}

.bio-api {
  position: relative;
  margin-top: 27px;
  margin-left: 17px;
  max-width: 251px;
  height: 36px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 36px;
  white-space: pre;
  color: #000000;
  font-size: 25px;
  font-weight: 400;
}
.sub-i0 {
  display: flex;
  position: relative;
  align-items: baseline;
  align-self: center;
  flex-direction: row;
  justify-content: flex-start;
  align-content: center;
  flex-wrap: wrap;
  /* margin-left: 67px; */
}

.view-i0 {
  display: flex;
  position: relative;
  align-items: center;
  flex-direction: column;
  border-width: 1px;
  border-style: solid;
  border-radius: 19px;
  border-color: transparent;
  background-color: #5d5b5b;
  width: 381px;
  height: 225px;
  margin-top: 10px;
  margin-left: 10px;
}

.tag {
  position: absolute;
  top: 163px;
  align-self: center;
  line-height: 28px;
  white-space: nowrap;
  color: #fdf9f9;
  font-size: 20px;
  z-index: 101;
}


.description {
  position: relative;
  margin-top: 20px;
  max-width: 369px;
  height: 28px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 28px;
  white-space: nowrap;
  color: #3e2525;
  font-size: 20px;
}

.mask {
  position: relative;
  margin-top: 27px;
  border-width: 1px;
  border-style: solid;
  border-radius: 18px;
  border-color: #979797;
  background-color: rgba(216, 216, 216, 0.51);
  width: 133px;
  height: 36px;
  font-weight: 400;
}

.label {
  position: absolute;
  top: 158px;
  align-self: center;
  line-height: 28px;
  white-space: nowrap;
  color: #fdf9f9;
  font-size: 20px;
}
.overlayer {
  position: relative;
  margin-top: 27px;
  border-width: 1px;
  border-style: solid;
  border-radius: 18px;
  border-color: #979797;
  background-color: rgba(216, 216, 216, 0.51);
  width: 133px;
  height: 36px;
  font-weight: 400;
}

.sub-i1 {
  display: flex;
  align-items: flex-start;
  flex-direction: column;
}


.word {
  position: absolute;
  top: 163px;
  align-self: center;
  line-height: 28px;
  white-space: nowrap;
  color: #fdf9f9;
  font-size: 20px;
}



.header {
  display: flex;
  position: relative;
  align-items: center;
  flex-direction: row;
  /* height: 20px; */
}


.item {
  position: relative;
  width: 268px;
  height: 263px;
}

.body {
  display: flex;
  position: relative;
  align-items: center;
  flex-direction: row;
  margin-top: 15px;
  height: 20px;
}


.repo-name-2 {
  position: relative;
  margin-top: 44px;
  max-width: 369px;
  height: 40px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 40px;
  white-space: pre;
  color: #ffffff;
  font-size: 28px;
}

@media screen and (max-width: 991px){
  .view-i0{
    width: 100%!important;
    margin-left: 0!important;
  }
  .mask{
    width: 100px!important;
    margin-bottom: 10px;
  }
  .sub-i0{
    margin-left: 0!important;
  }
    .page {
  display: flex;
  position: relative;
  align-items: flex-start;
  flex-direction: column;
  width: 100%;
  height: 100%;
  font-weight: 600;
}

.repo-name-wrapper-i0 {
  display: flex;
  position: absolute;
  top: 948px;
  left: 502px;
  align-items: center;
  flex-direction: row;
  border-width: 1px;
  border-style: solid;
  border-radius: 19px;
  border-color: #979797;
  background-color: #435676;
  width: 100%;
  height: 100%;
  line-height: 40px;
  white-space: pre;
}

.repo-name {
  position: absolute;
  top: 42px;
  left: 112px;
  color: #ffffff;
  font-size: 28px;
}

.repo-name-wrapper-i1 {
  box-sizing: border-box;
  display: flex;
  position: absolute;
  top: 948px;
  right: 116px;
  align-items: flex-start;
  flex-direction: row;
  border-width: 1px;
  border-style: solid;
  border-radius: 19px;
  border-color: #979797;
  background-color: #5d5b5b;
  padding-right: 111px;
  padding-left: 112px;
  height: 100%;
  line-height: 40px;
  white-space: pre;
}

.repo-name-1 {
  margin-top: 36px;
  color: #ffffff;
  font-size: 28px;
}

.wrapper-inner {
  display: flex;
  position: relative;
  align-items: flex-start;
  align-self: center;
  flex-direction: row;
  margin-top: 78px;
  padding: 0;
}

.primary {
  display: flex;
  align-items: flex-start;
  flex-direction: column;
  margin-right: 0;
  font-weight: 400;
  top: 45px;
  position: sticky;
}

.view {
  display: flex;
  position: relative;
  align-items: flex-start;
  flex-direction: row;
  justify-content: center;
}


.item {
  position: relative;
  width: 100%;
  height: 100%;
}

.name {
  position: relative;
  margin-top: 27px;
  margin-left: 17px;
  max-width: 251px;
  height: 49px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 49px;
  white-space: nowrap;
  color: #781212;
  font-size: 35px;
  font-weight: 600;
}

.login {
  position: relative;
  margin-left: 17px;
  max-width: 251px;
  height: 36px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 36px;
  white-space: nowrap;
  color: #758390;
  font-size: 25px;
  font-weight: 400;
}

.bio-api {
  position: relative;
  margin-top: 27px;
  margin-left: 17px;
  max-width: 251px;
  height: 36px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 36px;
  white-space: pre;
  color: #000000;
  font-size: 25px;
  font-weight: 400;
}
.sub-i0 {
  display: flex;
  position: relative;
  align-items: baseline;
  align-self: center;
  flex-direction: row;
  justify-content: flex-start;
  align-content: center;
  flex-wrap: wrap;
  /* margin-left: 67px; */
}

.mask {
  position: relative;
  margin-top: 27px;
  border-width: 1px;
  border-style: solid;
  border-radius: 18px;
  border-color: #979797;
  background-color: rgba(216, 216, 216, 0.51);
  width: 100%;
  height: 36px;
  font-weight: 400;
}

.overlayer {
  position: relative;
  margin-top: 27px;
  border-width: 1px;
  border-style: solid;
  border-radius: 18px;
  border-color: #979797;
  background-color: rgba(216, 216, 216, 0.51);
  width: 100%;
  height: 100%;
  font-weight: 400;
}


.header {
  display: flex;
  position: relative;
  align-items: center;
  flex-direction: row;
  height: 20px;
}


.item {
  position: relative;
  width: 100%;
  height: 100%;
}

.body {
  display: flex;
  position: relative;
  align-items: center;
  flex-direction: row;
  margin-top: 15px;
  height: 20px;
}


.repo-name-2 {
  position: relative;
  margin-top: 44px;
  max-width: 369px;
  height: 40px;
  overflow: hidden;
  text-overflow: ellipsis;
  line-height: 40px;
  white-space: pre;
  color: #ffffff;
  font-size: 28px;
}
  .wrapper-inner {
  flex-direction: column;
  }
  .primary {
  position: initial;
  }
  .sub-i0 {
  flex-direction: column;
  flex-wrap: nowrap;
  }
  .page{
      width: 100%;
  }
  .sub-i0{
    margin-top: 60px;
  }
}

main{
    padding: 0;
}
}
</style>
<script>
    STY_Method.vditorRender();
  </script>
</main>
<?$this->need('footer.php');?>