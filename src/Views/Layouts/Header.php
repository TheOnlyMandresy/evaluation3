<h2><a href="/">KGB</a></h2>

<nav>
    <?php if (isset($_SESSION['admin'])): ?>
    <h3>Secteur humain</h3>
    <ul>
        <li><a href="/users/agents">Agents</a></li>
        <li><a href="/users/contacts">Contacts</a></li>
        <li><a href="/users/targets">Cibles</a></li>
    </ul>
    
    <h3>Secteur action</h3>
    <ul>
        <li><a href="/missions/all">Missions</a></li>
        <li><a href="/missions/hideouts">Planques</a></li>
    </ul>
    
    <h3>Secteur system</h3>
    <ul>
        <li><a href="/system/countries">Pays/nationalité</a></li>
        <li><a href="/system/faculties">Facultés</a></li>
        <li><a href="/system/missions">Types de mission</a></li>
    </ul>

    <h3>Relatif au compte</h3>
    <ul>
        <li><a href="/logout">Deconnexion</a></li>
    </ul>
    <?php else: ?>

    <h3>Secteur public</h3>
    <ul>
        <li><a href="/login">Identification</a></li>
    </ul>
    
    <?php endif; ?>
</nav>