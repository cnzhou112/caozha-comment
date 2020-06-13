<?php
/**
* 源码名：caozha-comment（功能强大的原生PHP评论系统）
* Copyright © 2020 草札 （草札官网：http://caozha.com）
* 基于木兰宽松许可证 2.0（Mulan PSL v2）免费开源，您可以自由复制、修改、分发或用于商业用途，但需保留作者版权等声明。详见开源协议：http://license.coscl.org.cn/MulanPSL2
* caozha-comment (Software Name) is licensed under Mulan PSL v2. Please refer to: http://license.coscl.org.cn/MulanPSL2
* Github：https://github.com/cao-zha/caozha-comment   or   Gitee：https://gitee.com/caozha/caozha-comment
*/
?><style type="text/css">
    <?php if($this->cmt_config["is_like"]==false){echo ".is_like{display: none;}";}?>
    <?php if($this->cmt_config["is_bad"]==false){echo ".is_bad{display: none;}";}?>
    <?php if($this->cmt_config["is_reply"]==false){echo ".is_reply{display: none;}";}?>
</style>
<script id="PlReplyTemplate" type="text/template" >
    <div class="pl-post pl-post-reply">
        <div class="pl-textarea"><textarea class="pl-post-word" id="pl-520am-f-saytext-reply" placeholder="@ {{username}}："></textarea></div>
        <div class="pl-tools">
            <ul>
                <?php if($this->cmt_config["is_face"]){?><li onclick="caozha.showPickFace(event,1)"><i class="iconfont icon-face">&#xe60a;</i></li><?php }?>
                <?php if($this->cmt_config["is_img"]){?><li onclick="caozha.showPickImg(event,1)"><i class="iconfont icon-img">&#xe610;</i></li><?php }?>
                <?php if($this->cmt_config["is_captcha"]){?><li class="ShowPlKey">
                    <input type="text" id="pl-key-reply" class="pl-key" size="10" placeholder="验证码" />
                    <img src="<?=$this->cmt_url?>php/api.php?action=captcha" align="absmiddle" name="plKeyImg" class="plKeyImg" onclick="caozha.updateKey()" title="看不清楚,点击刷新" />
                </li><?php }?>
                <li class="pl-tools-lastchild"><button class="pl-submit-btn" onclick="caozha.submitComment(this,{{plid}})">发 布</button></li>
                <li  class="username"><i class="iconfont">&#xe613;</i><input type="text" id="pl-username-reply" class="pl-key" size="15" placeholder="你的昵称" value="" /></li>
            </ul>
        </div>
        <div class="pl-face-box"  id="pl-face-box-reply">
            <div class="pl-face-box-before"><a class="pl-icon icon-face"></a></div>
            <?php
            foreach ($this->cmt_faces as $vo){
                echo '<li  onclick="caozha.addplface(\'[/'.$vo[0].']\',1)"><a href="javascript:;" title="'.$vo[0].'"><img width=20 border=0 height=20 src="'.$this->cmt_url.'face/'.$vo[1].'" alt="'.$vo[0].'"></a></li>';
            }
            ?>
 </div>
        <div class="pl-img-box"  id="pl-img-box-reply">
            <div class="pl-img-box-before"><a class="pl-icon icon-img"></a></div>
            <div class="pl-img-file"><input placeholder="http://" type="text"> <button>添加图片</button></div>
        </div>
    </div>
    <div class="pl-showinfo pl-showinfo-reply">请先说点什么</div>
</script>
<script id="NewsCommentTemplate" type="text/template" >
    {{#if data}}
    {{#data }}
    <div class="pl-area pl-show-box" id="pl-show-box-{{plid}}">
        <div class="pl-area-userpic">
            <img id="pl-userpic" src="{{userpic}}">
        </div>
        <div class="pl-area-post">
            <div class="pl-show-title"><span>{{plusername}}</span> <span class="pl-show-time pl-fr">{{formattime}}</span></div>
            <div class="pl-show-saytext">{{{saytext}}}</div>
            <div class="pl-show-tools"><a id="pl-err-info-{{plid}}"></a> <a href="javascript:;" onclick="caozha.doForPl({{plid}},1,this)" class="is_like"><i class="caozha-iconfont caozha-good1"></i><span id="pl-1-{{plid}}">{{zcnum}}</span></a> <a href="javascript:;" onclick="caozha.doForPl({{plid}},0,this)" class="is_bad"><i class="caozha-iconfont caozha-bad1"></i><span id="pl-0-{{plid}}">{{fdnum}}</span></a> <a class="pl-reply is_reply" onclick="caozha.showReply({{plid}},'{{plusername}}')" href="javascript:;"><i class="iconfont">&#xe61c;</i></a></div>
            <div class="pl-show-replay"></div>
        </div>
        <div class="pl-clr"></div>
    </div>
    {{/data}}
    {{else}}
    <div class="lgy_no_data">
        <p><i class="iconfont icon-comment"></i></p>
    </div>
    {{/if}}
</script>

       <!--div class="pl-area-userpic">
        <img id="pl-userpic" src="<?=$this->cmt_url?>assets/nouserpic.gif">      </div-->
<div class="pl-area-post">
    <div class="pl-post">
        <div class="pl-textarea"><textarea class="pl-post-word" id="pl-520am-f-saytext" placeholder="写下你想说的，开始我们的对话"></textarea>
        </div>
        <div class="pl-tools">
            <ul>
                <?php if($this->cmt_config["is_face"]){?><li onclick="caozha.showPickFace(event,0)"><i class="iconfont icon-face">&#xe60a;</i></li><?php }?>
                <?php if($this->cmt_config["is_img"]){?><li onclick="caozha.showPickImg(event,0)"><i class="iconfont icon-img">&#xe610;</i></li><?php }?>
                <?php if($this->cmt_config["is_captcha"]){?><li class="ShowPlKey">
                    <div style="margin-top:5px;">
                        <input type="text" id="pl-key" class="pl-key" size="10" placeholder="验证码" />
                        <img src="<?=$this->cmt_url?>php/api.php?action=captcha" align="absmiddle" name="plKeyImg" class="plKeyImg" onclick="caozha.updateKey()" title="看不清楚,点击刷新" />
                    </div>
                </li><?php }?>
                <li class="pl-tools-lastchild"><button class="pl-submit-btn" id="pl-submit-btn-main" onclick="caozha.submitComment(this)">发 布</button></li>
                <li  class="username"><i class="iconfont">&#xe613;</i><input type="text" id="pl-username" class="pl-key" size="15" placeholder="你的昵称" value="" /></li>
            </ul>
        </div>
        <div class="pl-face-box" id="pl-face-box">
            <div class="pl-face-box-before"><a class="pl-icon icon-face"></a></div>
            <?php
            foreach ($this->cmt_faces as $vo){
                echo '<li  onclick="caozha.addplface(\'[/'.$vo[0].']\',0)"><a href="javascript:;" title="'.$vo[0].'"><img width=20 border=0 height=20 src="'.$this->cmt_url.'face/'.$vo[1].'" alt="'.$vo[0].'"></a></li>';
            }
            ?>
</div>
       <div class="pl-img-box"  id="pl-img-box">
            <div class="pl-img-box-before"><a class="pl-icon icon-img"></a></div>
            <div class="pl-img-file"><input placeholder="http://" type="text"> <button>添加图片</button></div>
        </div>
    </div>
</div>

<div class="pl-clr"></div>
<div class="pl-showinfo">请先说点什么</div>
<div class="pl-clr"></div>
<div class="pl-show-hot-list">
    <div class="pl-title">热门评论</div>
    <div class="pl-show-list" id="pl-show-hot"></div>
</div>
<div class="pl-clr" id="pl-start"></div>
<div class="pl-header"><em id="pl-joinnum">0</em>人参与，<em  id="pl-totalnum">0</em>条评论<span class="pl-userinfo" id="pl-userinfo"></span></div>
<div class="pl-show-list" id="pl-show-all"><div class="pl-null NewsComment_loading"><i class="pl-loading"></i>正在载入评论列表...</div></div>
<div id="pl-pagination"></div>
<button onclick="caozha.getNewsComment(0,this);" class="showAllComment buttonGray">查看更多</button>