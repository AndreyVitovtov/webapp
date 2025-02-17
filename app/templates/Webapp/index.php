<style>
    .app-header {
        height: 47vh;
        background-color: #262626;
    }

    .timer {
        height: 100%;
        display: flex;
        font-size: 1.3rem;
        gap: 3px;
        align-items: end;
        color: #fff;
        justify-content: center;
        padding-bottom: 50px;
    }

    .timer .block-group {
        display: flex;
        gap: 3px;
    }

    .timer .block {
        background: #222023;
        padding: 10px;
        border-radius: 8px;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 30px;
        height: 45px;
    }

    .timer .block:nth-child(1) {
        border-radius: 8px 2px 2px 8px;
    }

    .timer .block:nth-child(2) {
        border-radius: 2px 8px 8px 2px;
    }

    .timer .separator {
        padding: 10px 5px;
        font-weight: bold;
    }

    .timer .hidden {
        display: none;
    }

    .app-block-invite {
        width: 100%;
        height: 50px;
        position: fixed;
        bottom: 0;
        padding: 35px 20px 45px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #F8F8F8;
    }
    
    .app-button-invite {
        font-family: Arial, Helvetica, sans-serif;
        text-align: center;
        font-size: 14px;
        background-color: #40A7E3;
        color: #fff;
        border-radius: 5px;
        padding: 10px 20px;
        text-decoration: none;
        width: 100%;
    }

    .app-button-invite:hover {
        color: #fff;
    }

    html, body {
        height: 100vh;
        margin: 0;
        padding: 0;
        overflow-y: auto;
    }

    .app-body {
        padding: 20px;
    }

    html, body {
        overflow: auto;
        scrollbar-width: none; /* Для Firefox */
    }

    ::-webkit-scrollbar {
        display: none; /* Для Chrome, Safari */
    }


</style>

<div class="app-header">
    <div class="timer">
        <div class="block-group" id="days-container">
            <div class="block" id="days-tens">0</div>
            <div class="block" id="days-units">0</div>
        </div>
        <div class="separator" id="days-separator">:</div>
        <div class="block-group">
            <div class="block" id="hours-tens">0</div>
            <div class="block" id="hours-units">0</div>
        </div>
        <div class="separator">:</div>
        <div class="block-group">
            <div class="block" id="minutes-tens">0</div>
            <div class="block" id="minutes-units">0</div>
        </div>
        <div class="separator">:</div>
        <div class="block-group">
            <div class="block" id="seconds-tens">0</div>
            <div class="block" id="seconds-units">0</div>
        </div>
    </div>
</div>
<div class="app-body">
    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Illum, nesciunt rerum. Doloribus molestiae sed
        tenetur vitae. Dolores doloribus ea eos et facere fugit inventore modi, molestiae nihil nulla pariatur sed?
    </div>
    <div>Architecto assumenda at cum cupiditate deleniti ducimus earum eius, eum ex explicabo fugit illo ipsa laboriosam
        laudantium modi, mollitia natus nisi non pariatur quas quia, quibusdam quidem quis sed soluta?
    </div>
    <div>Iste minus numquam saepe voluptatibus? A architecto atque cupiditate debitis eaque fugiat illum ipsam mollitia
        nobis optio quae quis, quos ratione recusandae reiciendis sed sit sunt tempore veniam vitae voluptatibus?
    </div>
    <div>Alias architecto ducimus id laudantium quod rerum similique voluptate. Accusamus, commodi corporis culpa
        explicabo fuga impedit minus modi nesciunt nisi odio officia optio perspiciatis quae sequi similique tempore
        voluptate voluptates!
    </div>
    <div>Assumenda consequuntur dolore, doloremque fugit ipsum iste itaque officia, officiis possimus praesentium quae
        quaerat. Aliquid enim et ex, exercitationem explicabo ipsa iste omnis optio porro provident quisquam quod
        voluptatem voluptatum?
    </div>
    <div>Aspernatur cum dolorum eligendi id laborum maiores modi reiciendis rem repellendus voluptates? Animi assumenda
        doloremque enim esse et eveniet expedita inventore iure nulla, officia perspiciatis possimus quibusdam quod
        tenetur vero.
    </div>
    <div>Aliquam blanditiis dicta eaque, et fugiat hic itaque iure labore laborum libero nostrum pariatur perferendis
        porro recusandae reiciendis sint tempore voluptatibus? Architecto asperiores, facilis ipsa minima nihil quasi
        temporibus voluptate?
    </div>
    <div>Ab aliquam animi aperiam consequuntur debitis facere hic incidunt iusto maiores minus molestias, necessitatibus
        nostrum optio quibusdam quis quo reprehenderit rerum saepe sequi sit suscipit, tempora veniam voluptas.
        Assumenda, quas.
    </div>
    <div>Ab aliquid aut beatae dicta dignissimos dolor dolore dolorem dolorum exercitationem expedita facere in incidunt
        iure, iusto, labore minima minus modi, natus provident quam qui repudiandae saepe sapiente veniam voluptatibus!
    </div>
    <div>Alias deleniti ducimus exercitationem ipsum sed! Asperiores blanditiis consectetur consequatur dolorum illum
        inventore maiores nulla quidem repellendus sunt. Architecto aut cum dolor ducimus error inventore maiores nemo
        nihil obcaecati veniam.
    </div>
    <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est, iste quos? Aliquid at, voluptates! Blanditiis
        debitis eaque earum explicabo facilis vero voluptatibus? Enim eum ipsam modi odio quae repellat saepe!
    </div>
    <div>Culpa rem sunt vero voluptatem! Expedita ipsum, iure sed tenetur ullam voluptas! Assumenda, commodi consectetur
        deserunt, dignissimos eum iure officiis omnis pariatur quaerat, quidem repellendus sapiente sed sequi tempore
        ut?
    </div>
    <div>Adipisci assumenda doloremque doloribus dolorum, ducimus exercitationem fugiat impedit iste iure iusto labore
        laboriosam laborum laudantium libero modi nam obcaecati possimus quae quam, quas quia rem repellendus saepe
        ullam voluptatum?
    </div>
    <div>Consequatur eaque eligendi nemo officiis praesentium quae quos veritatis? Assumenda at molestias nobis nostrum
        temporibus! Dolore libero natus, optio provident reprehenderit repudiandae voluptatem. Ab deleniti laudantium
        odio provident sit veritatis!
    </div>
    <div>Accusantium architecto blanditiis commodi consectetur cum cumque deleniti explicabo illo nisi nobis, odio
        officia omnis, reprehenderit rerum, sapiente sed similique! Aspernatur cupiditate eaque enim eum ipsa
        laudantium, provident sunt voluptates.
    </div>
    <div>Maxime odit quaerat quis sequi! A eius fugit hic ipsa ipsam, iure laborum minima nam necessitatibus nobis odit,
        pariatur perferendis perspiciatis praesentium quas quod quos repellendus repudiandae suscipit vel voluptatum?
    </div>
    <div>Ab asperiores commodi culpa id laudantium magnam modi porro! Adipisci consequuntur doloremque eum expedita
        fugiat hic in itaque, labore neque nobis non numquam quaerat repellendus repudiandae sapiente tempore tenetur
        vero.
    </div>
    <div>Alias asperiores commodi cupiditate eum excepturi labore libero natus nostrum odit quibusdam, quisquam quod,
        totam. A ad delectus dolore dolorum est! Aperiam est expedita facere laudantium nostrum quis rerum voluptates!
    </div>
    <div>A eum incidunt modi quae qui quos tempore voluptatum. Autem corporis deleniti dicta explicabo fuga hic
        laudantium minus voluptatem. Ab, harum id natus omnis sequi veritatis. Ab enim facilis quidem.
    </div>
    <div>Alias, aliquam animi cumque deleniti deserunt labore quae sapiente similique vero. Atque culpa cum cupiditate
        maxime, odio perspiciatis quia unde ut veniam voluptate? Debitis ducimus magnam modi, necessitatibus quibusdam
        saepe?
    </div>
    <div>Aliquid assumenda cupiditate dicta dignissimos voluptates. Deleniti dignissimos eius eum illum in maxime neque,
        nobis numquam praesentium ratione, tempore unde vero. Adipisci culpa ea earum maxime molestiae nulla. Ab,
        reprehenderit.
    </div>
    <div>Consectetur magni, sed! Accusantium alias aspernatur assumenda, atque, debitis eum facilis fuga fugiat impedit
        laborum nam neque nobis, numquam quae quaerat quas quasi repellendus saepe suscipit temporibus tenetur voluptate
        voluptatibus.
    </div>
    <div>A assumenda culpa debitis dicta dignissimos dolores eligendi enim, est exercitationem facilis harum, illum ipsa
        itaque minima nam nesciunt nihil perspiciatis provident quos ratione similique soluta sunt tempora tenetur
        voluptatibus?
    </div>
    <div>Architecto dolore earum facere quam quibusdam sapiente totam? Ab atque deserunt doloribus ea eius excepturi hic
        ipsa ipsum itaque iure labore laboriosam magni maiores nesciunt quae rerum sunt, temporibus unde.
    </div>
    <div>Cupiditate earum eligendi enim facilis iure maxime nisi odit optio saepe! Accusamus adipisci animi consectetur
        delectus doloremque in magnam necessitatibus omnis reiciendis ullam? Autem fugit hic maiores molestiae sit
        tempore!
    </div>
    <div>A alias aliquam, amet cupiditate doloremque error fuga harum itaque minima nostrum optio perspiciatis
        repudiandae suscipit tempore totam ut voluptatem voluptatibus! Accusamus atque cupiditate dolor ea illo neque
        pariatur rem.
    </div>
    <div>Aliquid cumque doloribus ipsum itaque libero minus nam natus temporibus. Aut explicabo fugit harum inventore
        labore magni neque nihil nobis omnis recusandae? Commodi consectetur fugit iusto maiores rerum temporibus vel.
    </div>
    <div>Alias deleniti illo ipsam laborum molestiae, nostrum repellendus tenetur velit. Aliquam architecto, consectetur
        cumque deserunt dicta illum impedit inventore laudantium minus perferendis placeat praesentium provident quo
        repudiandae saepe, velit veniam!
    </div>
    <div>Adipisci commodi eius explicabo harum illo impedit incidunt neque nulla perferendis, quod saepe suscipit ullam
        vel veniam vitae! Animi, cum enim facere iste neque nihil nisi perferendis provident quaerat quo!
    </div>
    <div>Alias animi blanditiis cupiditate debitis deleniti explicabo in ipsam modi mollitia nam, possimus quos
        recusandae soluta tempore tenetur vel voluptatum. A aliquam corporis debitis laboriosam nihil omnis provident
        quibusdam veniam.
    </div>
</div>
<div class="app-block-invite">
    <a href="" class="app-button-invite"><?= __('invite participants') ?></a>
</div>