<?php 
/***************************************************************************
                             lang_smartfeed.php
                             -------------------
    begin                : Mon, Sep 3, 2007
    copyright            : (c) Mark D. Hamill
    email                : mhamill@computer.org

    $Id: $

 ***************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

// lang_smartfeed.php
// Written by Mark D. Hamill, mhamill@computer.org
// This software is designed to work with phpBB Version 2.0.22

if ( !defined('IN_PHPBB') )
{
	die('Hacking attempt');
}

$lang['smartfeed_atom_10'] = 'Atom 1.0';
$lang['smartfeed_rss_20'] = 'RSS 2.0';
$lang['smartfeed_rss_10'] = 'RSS 1.0';
$lang['smartfeed_rss_091'] = 'RSS 0.91 (RDF) - 15 items maximum';

$lang['smartfeed_copyright'] = ''; // Add a copyright statement for your site if it applies
$lang['smartfeed_editor'] = ''; // Most likely your site will not have a managing editor. If so enter email address of managing editor 
$lang['smartfeed_webmaster'] = ''; // If so inclined, enter email address of the webmaster of the phpBB forum

// Various error messages. Customize or internationalize as you prefer.
$lang['smartfeed_error_title'] = 'SmartFeed URL\'nizde hata';
$lang['smartfeed_error_introduction'] = 'Bu haber akýþýný toplamakta kullandýðýnýz URL\'de bir hata var. Bunun sonucunda, hiçbir içerik geri dönmedi. Bu bilgiyi problemi düzeltmek için bir kýlavuz olarak kullanýn. SmartFeed tarafýndan kullanýlabilen bir URL yaratmak için lütfen <a href="%s">Bu baðlantýyý</a> kullanmanýz gerektiðini not ediniz. Hata: ';
$lang['smartfeed_no_e_param'] = 'Buradaki "u" parametresi "e" parametresi ile birlikte kullanýlmalýdýr. ';
$lang['smartfeed_no_u_param'] = 'Buradaki "e" parametresi "u" parametresi ile birlikte kullanýlmalýdýr. ';
$lang['smartfeed_user_table_count_error'] = 'Kulanýcý tablolarýnda <i>user_id</i> haberlerin derlenmesi sýrasýnda veritabana hatasý.'; // Changed!
$lang['smartfeed_user_id_does_not_exist'] = 'Buradaki "u" parametresi bu sitenin hiçbir kullanýcýsýyla uyuþmuyor. Kullanýcý hesabý silinmiþ olabilir.';
$lang['smartfeed_user_table_password_error'] = 'Kulanýcý tablolarýnýn þifrelerinin derlenmesi sýrasýnda veritabana hatasý.';
$lang['smartfeed_bad_password_error'] = 'Tanýtým baþarýsýz. "e" "%s" parametresi "u" parametresiyle geçersiz "%s". Bu hata phpbb þifrenizin deðiþtirilmesinden yada SmartFeed güncellenmesinden kaynaklanabilir. Bu sorunu gidermek için, %s de yeni bir SmartFeed URL\'si oluþturunuz, daha sonra kopyalayýp haber akýþý okuyucunuza yapýþtýrýnýz.';
$lang['smartfeed_forum_access_reg'] = 'Tüm üyelerin eriþiminin olduðu <i>forum_ids</i> forumlarýn listesinin toplanýp derlenmesi sýrasýnda hata.';
$lang['smartfeed_forum_access_priv'] = 'Özel <i>forum_ids</i> listesinin derlenmesi sýrasýnda hata.';
$lang['smartfeed_user_error'] = 'Kullanýcý tablolarýnýn <i>user_lastvisit</i> verilerinin derlenmesi sýrasýnda hata.';
$lang['smartfeed_limit_format_error'] = 'Sýnýrlayýcý parametre tanýnan bir deðerde deðil.';
$lang['smartfeed_retrieve_error'] = 'Haber akýþý veritabaný bilgilerini derlenememektedir.';
$lang['smartfeed_feed_type_error'] = 'SmartFeed bu tür akýþ isteðini kabul etmemektedir.';
$lang['smartfeed_sort_by_error'] = 'SmartFeed sýralama metodu isteðini kabul etmemektedir.';
$lang['smartfeed_topics_only_error'] = 'SmartFeed bu tip konu deðeri isteðini kabul etmemektedir.';
$lang['smartfeed_lastvisit_param'] = 'Belirtilen son ziyaret parametresi geçersiz.';
$lang['smartfeed_reset_error'] = 'Veritabaný hatasý: Son ziyaret tarihiniz tekrar görüntülenemektedir.';
$lang['smartfeed_ip_auth_error'] = 'Bu IP adresinden haber akýþýný derlemek üzere bu URL kullanýlabilir. Bu mesajdan smartfeed_url.' . $phpEx . ' yi çalýþtýrýn ve bu haber akýþýný derlemek üzere yeni bir URL elde edin.'; 
$lang['smartfeed_not_logged_in'] = '<b>Siteye giriþ yapmadýðýnýz için, sadece aþaðýda listelenen genel forumlar listesine kaydolabilirsiniz. Ayný zamanda özel forumlara da kaydolmak isterseniz lütfen <a href="' . append_sid("login.$phpEx?redirect=smartfeed_url.$phpEx", true) . "\">giriþ</a> yapýnýz yada <a href=\"./profile.$phpEx?mode=register\">kaydolunuz</a> .</b>";
$lang['smartfeed_remove_yours_error'] = 'Buradaki <i>removemine</i> parametresi deðeri geçersiz.';
$lang['smartfeed_no_arguments'] = 'Bu script argümanlar gerektirmektedir.';
$lang['smartfeed_max_word_size_error'] = 'Buradaki <i>max_word_size</i> parametresi geçersiz.';
$lang['smartfeed_first_post_only_error'] = 'Buradaki <i>firstpostonly</i> parametresi geçersiz. Eðer varsa, sadece 1 deðerinde olmalýdýr.';
$lang['smartfeed_pms_not_for_public_users'] = 'Kaydolmamýþ üyeler için <i>pms</i> parametresi yetkili deðil.';
$lang['smartfeed_bad_pms_value'] = 'Buradaki <i>pms</i> Parametresi (özel mesajlar için) 1 deðerinde olmalýdýr.';
$lang['smartfeed_pm_retrieve_error'] = 'Özel mesaj veritabanýyla ilgili bilgiler derlenememektedir.';
$lang['smartfeed_pm_count_error'] = 'Veritabanýndaki kullanýcý özel mesaj sayýsý elde edilememektedir.';
$lang['smartfeed_p_parameter_obsolete'] = 'Authentication failure. Due to a software upgrade, the "p" parameter is no longer allowed. To solve this problem, create a new SmartFeed URL at %s, then copy and paste the generated URL into your newsreader application.';

// Miscellaneous variables
$lang['smartfeed_feed_title'] = $board_config['sitename'];
$lang['smartfeed_feed_description'] = $board_config['site_desc'];
$lang['smartfeed_image_title'] = $board_config['site_desc'] . ' Logo';
$lang['smartfeed_reply'] = 'Cevap';
$lang['smartfeed_reply_by'] = 'Cevaplayan';
$lang['smartfeed_posted_by'] = 'Gönderen';
$lang['smartfeed_version'] = 'Versiyon';

// These are used by smartfeed_url.php
$lang['smartfeed_feed_type'] = '<b>Haber Akýþý tipini seçiniz:</b><br />Haber akýþý okuyucunuza uygun bir formatý seçtiðinizden emin olunuz.';
$lang['smartfeed_page_title'] = 'SmartFeed';
$lang['smartfeed_explanation'] = "Kullanýcýlar günümüzde her geçen gün ilgilendikleri konularda bilgi ve haber akýþlarýný ilgili sitelere girmeden bilgisayarlarýndan izlemenin avantajlarýný görmektedir. Bu özellik, ilgilendiðiniz konulardaki son içerikleri okumak için siteleri ziyaret etmeden, bir <i>Haber Akýþý Okuyucusu</i> ile bu bilgileri biraraya getirerek birçok sitenin son geliþmelerini, bilgilerini ve haberlerini sizin için görüntülemektedir.<br /><br />\r\n Bu sitenin bazý forumlarý üyeler tarafýndan okunabilir, fakat diðerleri özel bir gruba kaydolmanýzý gerektirir. Normal olarak, Bu tür forumlara genel haber akýþý yoluyla eriþim yoktur. Bu nedenle, sitemiz <i>SmartFeed</i> kullanarak isteklerinize cevap vermektedir. Smartfeed, sitemize giriþ yapan üyelerin genel ve özel forumlardaki konu, bilgi ve haber akýþlarýna akýþ okuyucularýyla (RSS) eriþimini saðlayan bir phpBB modifikasyonudur. Sitemize giriþ yaptýktan sonra bu sayfada oluþturduðunuz bir özel URL yoluyla tüm içeriklere eriþim mümkün hale gelmektedir. Sizi ilgilendiren, kiþiselleþtirmek istediðiniz ve haber akýþýna dahil etmek istediðiniz forumlarý buradan seçebilirsiniz. Tercih ettiðiniz haber akýþý formatýný da seçebilirsiniz. SmartFeed RSS ve Atom protokolerini desteklemektedir. Uygun formatý seçme konusunda dikkatli olun. Aþaðýda <i>URL oluþtur</i> butonuna týklayarak kullanacaðýnýz özel URLyi elde edeceksiniz. Bu bilgiyi kopyalayýp siteye eriþimi saðlamak üzere haber akýþý okuyucunuza yapýþtýrýnýz.<br /><br />\r\n Haber okuyucusu ve haber akýþý konularýnda yeniyseniz, sizi <a href=\"http://fr.wikipedia.org/wiki/Agr%C3%A9gateur\" target=\"_blank\">Wikipédia nýn bu makalesini</a> okumaya davet ediyoruz. Burada yüklemek isteyebileceðiniz bir çok haber okuyucusuna yönlenidirlmiþ bir link verilmiþtir. Web tel siteleri yoluyla da haberlere eriþimi tercih edebilirsiniz ki <a href=\"http://www.bloglines.com\" target=\"_blank\">Bloglines</a>, linki özel olarak bu konuyu kapsamktadýr.<br /><br />Bu siteye kayýtlý üye deðilseniz, yine de haber akýþýna eriþimi saðlayabilirsiniz. Ancak, sadece genel forumlarýn listesine kaydolabilirsiniz.";
$lang['smartfeed_lastvisit'] = '<b>Akýþa eriþim saðlamak istediðinizde son giriþ tarihinizi yenilediniz mi?</b><br /> Sitemizin içeriðini okumak için sözkonusu akýþý kullanýyorsanýz <i>Evet</i> seçin. Bu siteyi düzenli olarak ziyaret ediyorsanýz <i>ve</i> siteyi ziyaret ettiðinizde akýþtaki konularýn okunmadý olarak görünmesini istiyorsanýz <i>Hayýr</i> seçin. Dikkat: önemli boyutlardaki akýþa dönmek için <i>Hayýr</i> seçin. Ýlave olarak, akýþýn güncellenmesi esnasýnda makalelere cevaplarý iþaretleyebilirsiniz.';
$lang['smartfeed_yes'] = 'Evet';
$lang['smartfeed_no'] = 'Hayýr';
$lang['smartfeed_all_forums']='Bütün Forumlar (Ýþaretle yada iþaretleri kaldýr)';
$lang['smartfeed_select_forums']='<b>Haber akýþý bu forumlardan iþaretli olanlara ait mesajlarý akýþýnýza dahil edecektir:</b>';
$lang['smartfeed_generate_url_text']='URL oluþtur';
$lang['smartfeed_reset_text']='Yenile';
$lang['smartfeed_auth_reg_text']='<i>(Sadece kayýtlý üyeler)</i>';
$lang['smartfeed_auth_acl_text']='<i>(Sadece özel eriþimi olan üyeler)</i>';
$lang['smartfeed_auth_mod_text']='<i>(Sadece Moderatörler)</i>';
$lang['smartfeed_auth_admin_text']='<i>(Sadece Yöneticiler)</i>';
$lang['smartfeed_limit_text']='<b>Mesajlarýn derlenmesi sýrasýnda, buradan yayýnlanan mesaj akýþlarýný sýnýrlandýrýn:</b><br />Eðer haber akýþý okuyucusu olarak navigatörünüzde ilave bir modül kulanýyorsanýz (Firefox için Sage gibi), oluþturulacak akýþta düzenli olarak bir cookie son eriþim zamanýnýzý tutacaktýr. Haber okuyucularýnýn çoðunluðunun cookies\'leri tanýmadýðýný da belirtmek isteriz.';
$lang['smartfeed_since_last_fetch_or_visit']='Haber akýþý son güncelleme veya son site ziyareti';
$lang['smartfeed_since_last_fetch_or_visit_value']='LF';
$lang['smartfeed_last_week']='7 gün';
$lang['smartfeed_last_week_value']='7 DAY';
$lang['smartfeed_last_day']='24 saat';
$lang['smartfeed_last_day_value']='1 DAY';
$lang['smartfeed_last_12_hours']='12 saat';
$lang['smartfeed_last_12_hours_value']='12 HOUR';
$lang['smartfeed_last_6_hours']='6 saat';
$lang['smartfeed_last_6_hours_value']='6 HOUR';
$lang['smartfeed_last_3_hours']='3 saat';
$lang['smartfeed_last_3_hours_value']='3 HOUR';
$lang['smartfeed_last_1_hours']='1 saat';
$lang['smartfeed_last_1_hours_value']='1 HOUR';
$lang['smartfeed_last_30_minutes']='30 dakika';
$lang['smartfeed_last_30_minutes_value']='30 MINUTE';
$lang['smartfeed_last_15_minutes']='15 dakika';
$lang['smartfeed_last_15_minutes_value']='15 MINUTE';
$lang['smartfeed_sort_by']='<b>Sýrala:</b><br />Standart uygulama bu forumda görünen mesajlarýn uygulamasýdýr, Yani kategoriler, Forum, Konu (Desc), Mesajýn tarih/saati.';
$lang['smartfeed_sort_forum_topic']='Standart Uygulama';
$lang['smartfeed_sort_forum_topic_desc']='Standart uygulama, ilk sýrada son mesajlar';
$lang['smartfeed_sort_post_date']='Mesajýn tarih/saati';
$lang['smartfeed_sort_post_date_desc']='Mesajýn tarih/saati, ilk sýrada son mesajlar';
$lang['smartfeed_count_limit'] = '<b>Akýþtaki maksimum mesaj sayýsý:</b><br />Pozitif nümerik bir deðer giriniz. Kritlerlerinze uygun bütün mesajlarý elde etmek için <i>All</i> giriniz.';
$lang['smartfeed_no_forums_selected']='Hiçbir forum seçmediniz, bu nedenle, bir URL oluþturulamadý. En az bir forum seçiniz.';
$lang['smartfeed_topics_only']='<b>Sadece yeni konularý göster?</b>';
$lang['smartfeed_url_label']='Gereksinim duyacaðýnýz haber akýþý URLsi <i>URL oluþtur</i> butonuna bastýktan sonra alttaki kutucukta görünecektir. <b>Bu bilgiyi kopyalayýp haber akýþý okuyucunuza yapýþtýrýnýz.</b> Seçeneklerinizi deðiþtirirseniz, yeniden <i>URL Oluþtur</i> butonuna týklayýn ve yeni bir URL elde edin.';
$lang['smartfeed_ip_auth']='<b>Haber akýþýna IP ile tanýmlanmayý aktive ettiniz mi?</b><br />Bu belki URL korsanlýðý saldýrýlarýna karþý ilave güvenlik tedbiri olarak kullanýlabilir. Oluþturulan URL sadece bilgisayarýnýzda desteklenen IP adres havuzu için geçerli olacaktýr. Örneðin, Ip ile haber akýþý tanýmlamasý aktif iken ve þu anki IP adresiniz 123.45.67.89 ise, akýþ sadece 123.45.67.*. adresleri aralýðýndakilere sayfalarýn içine eriþebilir olacaktýr.';
$lang['smartfeed_remove_yours']='<b>Akýþtaki mesajlarýmý dýþarý çýkart?</b>';
$lang['smartfeed_max_size']='<b>Mesaj baþýna gösterilecek maksimum kelime sayýsý:</b><br />Pozitif nümerik bir deðer giriniz. Tüm mesajlarý göstermek için <i>All</i> giriniz. Dikkat: Bir sayý girmek haber akýþýnda hatalara neden olabilir.';
$lang['smartfeed_max_words_wanted']='All';
$lang['smartfeed_size_error']='Bu alana pozitif nümerik bir deðer yada  All kelimesi girilmelidir.';
$lang['smartfeed_count_limit_error']='Burada <i>count_limit</i> parametresi 0\'dan büyük olmalýdýr.';
$lang['smartfeed_count_limit_consistency_error']= 'Burada <i>count_limit</i> parametresi sadece <i>sort_by</i> parametresi <i>postdate_desc</i> üzerinde ayarlandýðýnda kullanýlabilir.';
$lang['smartfeed_first_post_only']='sadece ilk mesaj?';
$lang['smartfeed_private_messages_in_feed']='<b>Akýþta özel mesajlarý göster?</b>';
$lang['smartfeed_no_mcrypt'] = '<b>*** Warning! PHP mcrypt extension is not available! Consequently only public forums can be selected. ***</b>';

// Used in Admininstrator interface to smartfeed_url.php
$lang['smartfeed_advertising_interface_title'] = 'Yöneticinin reklam seçenekleri';
$lang['smartfeed_enable_ads'] = '<b>Akýþta reklamlarý göster?</b>';
$lang['smartfeed_set_ad_options'] = 'Reklam fonksiyonunu aktive et';
$lang['smartfeed_set_top_options'] = 'Sayfanýn üzerinde bir reklam göster';
$lang['smartfeed_set_middle_options'] = 'Akýþ içinde konular arasýnda bir reklam göster';
$lang['smartfeed_set_bottom_options'] = 'Sayfa altýnda bir reklam göster';
$lang['smartfeed_ad_item_title'] = '<b>Reklam Baþlýðý</b><br />Bu bölüm aktive edildiyse istenmektedir. Sadece basit metin kullanýn; hiç bir özel karakter veya HTML kullanmayýn.';
$lang['smartfeed_ad_item_link'] = '<b>Ýlave ayrýntýlara link</b><br />Uygulanabilir deðilse bu alaný boþ býrakabilirsiniz. Linkin http:// ile baþladýðýndan emin olun';
$lang['smartfeed_ad_item_desc'] = '<b>Reklamýn tam tanýmý</b><br />Uygulanabilir deðilse bu alaný boþ býrakabilirsiniz. Bir çok durumda, sunulan hizmet veya ürünle ilgili ilave ayrýntýlarý ekleyebilirsiniz. basit metin kullanabilirsiniz, HTML veya XML içeriði RSS veya Atom akýþýna spesifik olarak ilave edilmiþtir. Not: Bu bütün haber akýþý okuyucularýnýn HTML çevrimi yaptýðý yada haber akýþlarýný düzgün bir þekilde gösterdiði anlamýna gelmemelidir. Haber akýþý okuyucularýnýn çoðu desteklemediðinden Javascript kullanmayýnýz. Bütün (\) barý içindekiler silindi.';
$lang['smartfeed_ad_item_header_top'] = 'Reklam sayfa üzerinde';
$lang['smartfeed_ad_item_header_middle'] = 'Reklam akýþýn ortasýnda';
$lang['smartfeed_ad_item_header_bottom'] = 'Reklam sayfa altýnda';
$lang['smartfeed_ad_item_repeat'] = '<b>Araya reklam girmeden önce akýþta gösterilecek konu sayýsýný giriniz</b><br />Ýstenmekte ve 0\'dan büyük olmalýdýr.';
$lang['smartfeed_ad_clear'] = 'Bütün reklam bölümleri alanlar&#305;n&#305; sil';
$lang['smartfeed_repeat_must_be_numeric'] = 'Akýþta gösterilecek mesaj sayýsý sayýsal olmalýdýr.';
$lang['smartfeed_repeat_must_be_greater_0'] = 'Akýþta gösterlecek mesaj sayýsý 0\\\'dan büyük olmalýdýr.';
$lang['smartfeed_title_required'] = 'Bir bölüm aktive edildiðinde, baþlýk alaný bilgilendirilmelidir.';
$lang['smartfeed_advertising_introduction'] = 'Bu bölüm sadece yöneticilere görünür.<br /><br />Smartfeed kullanýcýlara sunulan akýþ içine reklam girmeye izin verir. Reklamlarý aktive, dezaktive etmek, ayarlamak için bu ara yüzü kullanýn. Bunlar diðer bütün konular gibi akýþta görünürler, fakat reklamlar olarak açýkça tanýmlanmýþ olmalýdýr. Reklamlar akýþta üç yerde gösterilebilir: ilk konudan önce, akýþýn altýnda, veya periyodik olarak akýþ içinde. IE 7 gibi bazý akýþ okuyucularý içinde gösterilecek konularla ilgili uygulamayý deðiþtirmeye izin verdiðini unutmayýn. Sonuç olarak, reklamýn akýþta belirtilen yerde gösterileceðini garanti edemeyiz. Bölümlerin her biri aktive edilebilir yada edilmeyebilir. Ýþaretlenen baþlýca kutucuklarla içerik belki aktive edilmiþ yada edilmemiþ olabilir. Eðer dezaktive edilmiþse, reklam alanýnda mevcut olan bütün bilgi daha sonra aktive edilebilir.<br /><br />Bu hatlarýn yazýmý sýrasýnda Google Adsense RSS ve sonuçlarýný desteklememektedir. Google Adsense ile saðlanan javascript bu durumda þüphesiz çalýþmayacaktýr. Bizzat ilanlarla haber akýþýnýn içeriðini bir haber akýþý okuyucusu deðiþkeni yardýmýyla reklam metinin düzgün bir þekilde görüntülenip görüntülenmediðini ve içeriðinizin uygun olup olmadýðýný anlamak üzere gözden geçirmelisiniz. Farklý haber akýþý okuyucularýnýn tamamen farklý sonuçlar verebileceðini unutmayýn.<br /><br />Navigatörünüzün bu site üzerinden popup penceresi açýlmasýna izin verecek þekilde ayarlandýðýný kontrol edin. ayrýca, hata mesajlarý alýndýysa, gösterim için tedbir almýþ olmadýðýnýzdandýr.';
$lang['smartfeed_advertising_path_error'] = 'Reklam verilerinizi içeren dosyalar? olu?turulam?yor ve okunam?yor. Bu durum, haz?r i?levi yerine getirecek klasör veya dosyan?n gerekli yetkilere sahip olmad???n? gösterir.';
$lang['smartfeed_ad_data_saved'] = 'Ýlan seçenekleriniz kaydedildi';
$lang['smartfeed_ad_data_invalid_user'] = 'Ýlan seçenekleriniz kaydedilmedi. Þüphesiz bir korsan teþebbüsü bu hatanýn kaynaðýdýr. Çünkü reklam verilerini yedekleyen kullanýcý yönetici ayrýcalýðýnda deðil.';
$lang['smartfeed_ad_data_access_error'] = 'Reklam bilgilerini içeren dosyaya ulaþýlamýyor. Þüphesiz bu dosya izinleriyle ilgili bir problemdir.';
$lang['smartfeed_ad_feed_category'] = 'Reklam'; // The feed item category to use for ads, and also in the item title to distinguish the item as advertising
$lang['smartfeed_show_ads_to_public_only'] = 'Reklamlarý genel kullanýcýlara göster (kayýtlý olmayanlar). sadece reklamlar aktive edilmiþse uygulanabilir';

?>
