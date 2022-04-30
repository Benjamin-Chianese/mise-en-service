<?php
require('../includes/head.php'); 



  
	   ################### Traitemement $choix NAT deuxieme partie #########################
	    

	     echo '<center>
	    <form method="post" action="pfsense.php">
	     <h3> Création template Pfsense</h3>
            <table border="1">
                <tr>
                    <td>FSN (fsn01747)</td>
                    <td>IP WAN (141.0.205.70/24)</td>
                    <td>Passerelle WAN (141.0.205.1)</td>
                    <td>IP LAN (192.168.1.254/24)</td>
                    <td>Type</td>
                </tr>
                <tr>      
                        <td><input  type="text"  class="form-control" name="fsn" value="'.$_POST['fsn'].'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_wan" value="'.$_POST['ip_wan'].'" /></td>
                        <td><input  type="text"  class="form-control" name="gat_wan" value="'.$_POST['gat_wan'].'" /></td>
                        <td><input  type="text"  class="form-control" name="ip_lan" value="'.$_POST['ip_lan'].'" /></td>
                        <td><select name="type" class="form-control">
                                <option value="'.$_POST['type'].'">'.$_POST['type'].'</option>
                        		<option value="MPLS">MPLS</option>
                            	<option value="Pepinire">Pepinire</option>
                            	</select>
                        </td>
                        </tr>
  
                
  </table><br/><br/>

	    <button type="submit" class="btn btn-outline-success btn-sm mb-2">Generation</button>
	    </form>
	    </center>';
	    

	 
	      
	      
	      
	      if (!empty($_POST['fsn']) && !empty($_POST['ip_wan']) && !empty($_POST['gat_wan']) && !empty($_POST['ip_lan']) ){
	          
	          $explode_wan = explode('/',$_POST['ip_wan']);
	          $explode_lan = explode('/',$_POST['ip_lan']);
	          $explode_gat = explode('.',$explode_lan[0]);
	          $gat_lan_end = $explode_gat[3] -1;
	          $gat_lan = $explode_gat[0].'.'.$explode_gat[1].'.'.$explode_gat[2].'.'.$gat_lan_end;
	          
	     $template ='<?xml version="1.0"?>
<pfsense>
	<version>17.9</version>
	<lastchange></lastchange>
	<system>
		<optimization>normal</optimization>
		<hostname>'.$_POST['fsn'].'</hostname>
		<domain>vcpe.fullsave.net</domain>
		<dnsserver>141.0.202.202</dnsserver>
		<dnsserver>141.0.202.203</dnsserver>
	    <group>
		<name>all</name>
		<description><![CDATA[All Users]]></description>
		<scope>system</scope>
		<gid>1998</gid>
		<member>0</member>
    	</group>
    	<group>
    		<name>admins</name>
    		<description><![CDATA[System Administrators]]></description>
    		<scope>system</scope>
    		<gid>1999</gid>
    		<member>0</member>
    		<priv>page-all</priv>
    	</group>
    	<user>
    		<name>admin</name>
    		<descr><![CDATA[System Administrator]]></descr>
    		<scope>system</scope>
    		<groupname>admins</groupname>
    		<bcrypt-hash>$2b$10$BauQCDTxRxlyse19fsAXceNXvusFgWm3yER9jREQGsnI0XqImyyyW</bcrypt-hash>
    		<uid>0</uid>
    		<priv>user-shell-access</priv>
    	</user>
    	<user>
    		<scope>user</scope>
    		<bcrypt-hash>$2b$10$IwcghSD3PxzDk5u0nUHz3u1dFmvQbgIXcX7Ek/P9EhlXNMhF7gLPO</bcrypt-hash>
    		<descr></descr>
    		<name>srancid</name>
    		<expires></expires>
    		<dashboardcolumns>2</dashboardcolumns>
    		<authorizedkeys>c3NoLXJzYSBBQUFBQjNOemFDMXljMkVBQUFBREFRQUJBQUFCQVFDZk90NTQ4TVNmS29MRHA1dk9rb3VHcWpsZEQ2N1ZDc0hRY0UvK0ViQzdJenIrdVBKREpZU1RTN25yTlQ5MmVDVmFDMzE4eFRHbGpMRURyUll2UXZ2SW5iRnI2UDUrek9DMnJDeGdiVTQ5cW1zczdOS2ZldkFYWGREV1lTeFl1M3N2Qk5WdzJNd0RGTjM4YkMrYWxDRWVvK2l1WWl5YlIxZWU1UE5nZ1h4NXNEU3c5L0Mwdmt3T2tPM1grZUkxakx5WE9welhMWVJQYklNU0x3V2p0VTdaMTNSeTlZVzVmVHVPeHhVMmthOHlzME0vbVRMTnVKRWowNG95QTZncnA1b2R3akV3RVJPYW5WVGhqSGNmWXFiejRZazJtY3I5Zm4yQm42VHFvSktlWEVCUUYzNVFpblZ3QlpiV0JOWTJSc3Eya1BiOWVkc2Fma3JTNEpaekl5NWggcmFuY2lkQGZzLW1vbi0wMDA0</authorizedkeys>
    		<ipsecpsk></ipsecpsk>
    		<webguicss>pfSense.css</webguicss>
    		<uid>2000</uid>
    		<priv>user-shell-access</priv>
    	</user>
		<nextuid>2001</nextuid>
		<nextgid>2000</nextgid>
		<timeservers>ntp1.fullsave.com ntp2.fullsave.com</timeservers>
		<webgui>
			<protocol>https</protocol>
			<loginautocomplete></loginautocomplete>
			<ssl-certref>5b59cbf93262a</ssl-certref>
			<dashboardcolumns>2</dashboardcolumns>
			<port>65080</port>
			<max_procs>2</max_procs>
			<disablehttpredirect></disablehttpredirect>
			<nodnsrebindcheck></nodnsrebindcheck>
			<webguicss>pfSense.css</webguicss>
			<logincss>1e3f75;</logincss>
			<webguihostnamemenu>fqdn</webguihostnamemenu>
			<interfacessort></interfacessort>
		</webgui>
		<disablenatreflection>yes</disablenatreflection>
		<disablesegmentationoffloading></disablesegmentationoffloading>
		<disablelargereceiveoffloading></disablelargereceiveoffloading>
		<ipv6allow></ipv6allow>
		<powerd_ac_mode>hadp</powerd_ac_mode>
		<powerd_battery_mode>hadp</powerd_battery_mode>
		<powerd_normal_mode>hadp</powerd_normal_mode>
		<bogons>
			<interval>monthly</interval>
		</bogons>
		<timezone>Europe/Paris</timezone>
		<serialspeed>115200</serialspeed>
		<primaryconsole>serial</primaryconsole>
		<enablesshd>enabled</enablesshd>
		<maximumstates></maximumstates>
		<aliasesresolveinterval></aliasesresolveinterval>
		<maximumtableentries>500000</maximumtableentries>
		<maximumfrags></maximumfrags>
		<reflectiontimeout></reflectiontimeout>
		<language>en_US</language>
		<sshguard_threshold></sshguard_threshold>
		<sshguard_blocktime></sshguard_blocktime>
		<sshguard_detection_time></sshguard_detection_time>
		<sshguard_whitelist>93.93.40.240/28 193.84.73.8/32 100.80.8.0/24</sshguard_whitelist>
		<dnsserver>141.0.202.202</dnsserver>
		<dnsserver>141.0.202.203</dnsserver>
		<dns1gw>none</dns1gw>
		<dns2gw>none</dns2gw>
	</system>
	<interfaces>
		<wan>
			<enable></enable>
			<if>vmx0</if>
			<ipaddr>'.$explode_wan[0].'</ipaddr>
			<ipaddrv6></ipaddrv6>
			<subnet>'.$explode_wan[1].'</subnet>
			<gateway>GW_WAN</gateway>
			<blockpriv>on</blockpriv>
			<blockbogons>on</blockbogons>
			<media></media>
			<mediaopt></mediaopt>
			<dhcp6-duid></dhcp6-duid>
			<dhcp6-ia-pd-len>0</dhcp6-ia-pd-len>
			<subnetv6></subnetv6>
			<gatewayv6></gatewayv6>
		</wan>
		<lan>
			<enable></enable>
			<if>vmx1</if>
			<descr><![CDATA[LAN]]></descr>
			<ipaddr>'.$explode_lan[0].'</ipaddr>
			<subnet>'.$explode_lan[1].'</subnet>';
			if($_POST['type']  == 'MPLS'){
			    $template .= '<gateway>MPLSGW</gateway>';
			}
			$template .= '<spoofmac></spoofmac>
		</lan>
	</interfaces>
	<staticroutes></staticroutes>
	<dhcpd>
		<lan>
		    <enable></enable>
			<range>
				<from>'.$explode_gat[0].'.'.$explode_gat[1].'.'.$explode_gat[2].'.100</from>
				<to>'.$explode_gat[0].'.'.$explode_gat[1].'.'.$explode_gat[2].'.199</to>
				<domain>lan</domain>
			</range>
			<failover_peerip></failover_peerip>
			<dhcpleaseinlocaltime></dhcpleaseinlocaltime>
			<defaultleasetime></defaultleasetime>
			<maxleasetime></maxleasetime>
			<netmask></netmask>
			<gateway></gateway>
			<domain></domain>
			<domainsearchlist></domainsearchlist>
			<ddnsdomain></ddnsdomain>
			<ddnsdomainprimary></ddnsdomainprimary>
			<ddnsdomainkeyname></ddnsdomainkeyname>
			<ddnsdomainkeyalgorithm>hmac-md5</ddnsdomainkeyalgorithm>
			<ddnsdomainkey></ddnsdomainkey>
			<mac_allow></mac_allow>
			<mac_deny></mac_deny>
			<ddnsclientupdates>allow</ddnsclientupdates>
			<tftp></tftp>
			<ldap></ldap>
			<nextserver></nextserver>
			<filename></filename>
			<filename32></filename32>
			<filename64></filename64>
			<rootpath></rootpath>
			<numberoptions></numberoptions>
		</lan>
	</dhcpd>
	<dhcpdv6>
		<lan>
			<range>
				<from>::1000</from>
				<to>::2000</to>
			</range>
			<ramode>assist</ramode>
			<rapriority>medium</rapriority>
			<prefixrange>
				<from></from>
				<to></to>
				<prefixlength>48</prefixlength>
			</prefixrange>
			<defaultleasetime></defaultleasetime>
			<maxleasetime></maxleasetime>
			<netmask></netmask>
			<domain></domain>
			<domainsearchlist></domainsearchlist>
			<ddnsdomain></ddnsdomain>
			<ddnsdomainprimary></ddnsdomainprimary>
			<ddnsdomainkeyname></ddnsdomainkeyname>
			<ddnsdomainkeyalgorithm>hmac-md5</ddnsdomainkeyalgorithm>
			<ddnsdomainkey></ddnsdomainkey>
			<ddnsclientupdates>allow</ddnsclientupdates>
			<tftp></tftp>
			<ldap></ldap>
			<bootfile_url></bootfile_url>
			<dhcpv6leaseinlocaltime></dhcpv6leaseinlocaltime>
			<numberoptions></numberoptions>
		</lan>
	</dhcpdv6>
	<snmpd>
		<syslocation>TLS00</syslocation>
		<syscontact>support@fullsave.com</syscontact>
		<rocommunity>fscommunity</rocommunity>
		<modules>
			<mibii></mibii>
			<netgraph></netgraph>
			<pf></pf>
			<hostres></hostres>
			<ucd></ucd>
			<regex></regex>
		</modules>
		<enable></enable>
		<pollport>161</pollport>
		<trapserver></trapserver>
		<trapserverport>162</trapserverport>
		<trapstring></trapstring>
		<bindip>all</bindip>
	</snmpd>
	<diag>
		<ipv6nat>
			<ipaddr></ipaddr>
		</ipv6nat>
	</diag>
	<syslog>
		<filterdescriptions>1</filterdescriptions>
	</syslog>
	<nat>
		<outbound>
			<mode>automatic</mode>
		</outbound>
	</nat>
	<filter>
		<rule>
			<id></id>
			<tracker>1532613213</tracker>
			<type>pass</type>
			<interface>wan</interface>
			<ipprotocol>inet</ipprotocol>
			<tag></tag>
			<tagged></tagged>
			<max></max>
			<max-src-nodes></max-src-nodes>
			<max-src-conn></max-src-conn>
			<max-src-states></max-src-states>
			<statetimeout></statetimeout>
			<statetype><![CDATA[keep state]]></statetype>
			<os></os>
			<protocol>tcp</protocol>
			<source>
				<address>FS_Admin</address>
			</source>
			<destination>
				<network>(self)</network>
				<port>22</port>
			</destination>
			<descr><![CDATA[Admin default rule]]></descr>
			<created>
				<time>1532613213</time>
				<username>admin@93.93.40.254</username>
			</created>
			<updated>
				<time>1532613225</time>
				<username>admin@93.93.40.254</username>
			</updated>
		</rule>
		<rule>
			<id></id>
			<tracker>1532613238</tracker>
			<type>pass</type>
			<interface>wan</interface>
			<ipprotocol>inet</ipprotocol>
			<tag></tag>
			<tagged></tagged>
			<max></max>
			<max-src-nodes></max-src-nodes>
			<max-src-conn></max-src-conn>
			<max-src-states></max-src-states>
			<statetimeout></statetimeout>
			<statetype><![CDATA[keep state]]></statetype>
			<os></os>
			<protocol>tcp</protocol>
			<source>
				<address>FS_Admin</address>
			</source>
			<destination>
				<network>(self)</network>
				<port>65080</port>
			</destination>
			<descr><![CDATA[Admin default rule]]></descr>
			<updated>
				<time>1532613238</time>
				<username>admin@93.93.40.254</username>
			</updated>
			<created>
				<time>1532613238</time>
				<username>admin@93.93.40.254</username>
			</created>
		</rule>
		<rule>
			<id></id>
			<tracker>1532613694</tracker>
			<type>pass</type>
			<interface>wan</interface>
			<ipprotocol>inet</ipprotocol>
			<tag></tag>
			<tagged></tagged>
			<max></max>
			<max-src-nodes></max-src-nodes>
			<max-src-conn></max-src-conn>
			<max-src-states></max-src-states>
			<statetimeout></statetimeout>
			<statetype><![CDATA[keep state]]></statetype>
			<os></os>
			<protocol>udp</protocol>
			<source>
				<address>FS_Supervision</address>
			</source>
			<destination>
				<network>(self)</network>
				<port>161</port>
			</destination>
			<descr><![CDATA[Admin default rule]]></descr>
			<updated>
				<time>1532613694</time>
				<username>admin@93.93.40.254</username>
			</updated>
			<created>
				<time>1532613694</time>
				<username>admin@93.93.40.254</username>
			</created>
		</rule>
		<rule>
			<id></id>
			<tracker>1627378420</tracker>
			<type>pass</type>
			<interface>wan</interface>
			<ipprotocol>inet</ipprotocol>
			<tag></tag>
			<tagged></tagged>
			<max></max>
			<max-src-nodes></max-src-nodes>
			<max-src-conn></max-src-conn>
			<max-src-states></max-src-states>
			<statetimeout></statetimeout>
			<statetype><![CDATA[keep state]]></statetype>
			<os></os>
			<protocol>icmp</protocol>
			<icmptype>any</icmptype>
			<source>
				<address>FS_Supervision</address>
			</source>
			<destination>
				<network>(self)</network>
			</destination>
			<descr><![CDATA[Admin default rule]]></descr>
			<updated>
				<time>1627378420</time>
				<username><![CDATA[admin@93.93.40.243 (Local Database)]]></username>
			</updated>
			<created>
				<time>1627378420</time>
				<username><![CDATA[admin@93.93.40.243 (Local Database)]]></username>
			</created>
		</rule>
		<rule>
			<type>pass</type>
			<ipprotocol>inet</ipprotocol>
			<descr><![CDATA[Default allow LAN to any rule]]></descr>
			<interface>lan</interface>
			<tracker>0100000101</tracker>
			<source>
				<network>lan</network>
			</source>
			<destination>
				<any></any>
			</destination>
		</rule>
		<rule>
			<type>pass</type>
			<ipprotocol>inet6</ipprotocol>
			<descr><![CDATA[Default allow LAN IPv6 to any rule]]></descr>
			<interface>lan</interface>
			<tracker>0100000102</tracker>
			<source>
				<network>lan</network>
			</source>
			<destination>
				<any></any>
			</destination>
		</rule>
		<separator>
			<wan></wan>
		</separator>
	</filter>
	<shaper></shaper>
	<ipsec></ipsec>
	<aliases>
		<alias>
			<name>FS_Admin</name>
			<type>network</type>
			<address>93.93.40.240/28 193.84.73.8/32 100.80.8.0/24</address>
			<descr></descr>
			<detail><![CDATA[Entry added Thu, 26 Jul 2018 15:53:13 +0200]]></detail>
		</alias>
		<alias>
			<name>FS_Supervision</name>
			<type>network</type>
			<address>93.93.40.161/32 93.93.40.163/32 93.93.40.165/32 93.93.40.167/32 93.93.40.169/32 93.93.40.171/32 93.93.45.8/30 93.93.47.4/30 141.0.200.4/30 193.84.73.8/30 172.16.255.8/29 172.18.23.8/29 172.19.16.224/32 172.19.16.254/32 172.30.254.0/24 172.30.255.0/24 193.84.73.8/32 100.80.8.0/24</address>
			<descr></descr>
			<detail><![CDATA[Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200||Entry added Thu, 26 Jul 2018 16:01:03 +0200]]></detail>
		</alias>
	</aliases>
	<proxyarp></proxyarp>
	<cron>
		<item>
			<minute>1,31</minute>
			<hour>0-5</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 adjkerntz -a</command>
		</item>
		<item>
			<minute>1</minute>
			<hour>3</hour>
			<mday>1</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /etc/rc.update_bogons.sh</command>
		</item>
		<item>
			<minute>*/60</minute>
			<hour>*</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /usr/local/sbin/expiretable -v -t 3600 sshlockout</command>
		</item>
		<item>
			<minute>*/60</minute>
			<hour>*</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /usr/local/sbin/expiretable -v -t 3600 webConfiguratorlockout</command>
		</item>
		<item>
			<minute>1</minute>
			<hour>1</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /etc/rc.dyndns.update</command>
		</item>
		<item>
			<minute>*/60</minute>
			<hour>*</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /usr/local/sbin/expiretable -v -t 3600 virusprot</command>
		</item>
		<item>
			<minute>30</minute>
			<hour>12</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /etc/rc.update_urltables</command>
		</item>
		<item>
			<minute>1</minute>
			<hour>0</hour>
			<mday>*</mday>
			<month>*</month>
			<wday>*</wday>
			<who>root</who>
			<command>/usr/bin/nice -n20 /etc/rc.update_pkg_metadata</command>
		</item>
	</cron>
	<wol></wol>
	<rrd>
		<enable></enable>
	</rrd>
	<load_balancer>
		<monitor_type>
			<name>ICMP</name>
			<type>icmp</type>
			<descr><![CDATA[ICMP]]></descr>
			<options></options>
		</monitor_type>
		<monitor_type>
			<name>TCP</name>
			<type>tcp</type>
			<descr><![CDATA[Generic TCP]]></descr>
			<options></options>
		</monitor_type>
		<monitor_type>
			<name>HTTP</name>
			<type>http</type>
			<descr><![CDATA[Generic HTTP]]></descr>
			<options>
				<path>/</path>
				<host></host>
				<code>200</code>
			</options>
		</monitor_type>
		<monitor_type>
			<name>HTTPS</name>
			<type>https</type>
			<descr><![CDATA[Generic HTTPS]]></descr>
			<options>
				<path>/</path>
				<host></host>
				<code>200</code>
			</options>
		</monitor_type>
		<monitor_type>
			<name>SMTP</name>
			<type>send</type>
			<descr><![CDATA[Generic SMTP]]></descr>
			<options>
				<send></send>
				<expect>220 *</expect>
			</options>
		</monitor_type>
	</load_balancer>
	<widgets>
		<sequence>system_information:col1:open:0,interfaces:col2:open:0,log:col2:open:0</sequence>
		<period>10</period>
	</widgets>
	<openvpn></openvpn>
	<dnshaper></dnshaper>
	<unbound>
		<dnssec></dnssec>
		<active_interface>all</active_interface>
		<outgoing_interface>all</outgoing_interface>
		<custom_options></custom_options>
		<hideidentity></hideidentity>
		<hideversion></hideversion>
		<dnssecstripped></dnssecstripped>
		<port></port>
		<system_domain_local_zone_type>transparent</system_domain_local_zone_type>
	</unbound>
	<revision>
		<time>1532631539</time>
		<description><![CDATA[admin@93.93.40.254: /interfaces.php made unknown change]]></description>
		<username>admin@93.93.40.254</username>
	</revision>
	<cert>
		<refid>5b59cbf93262a</refid>
		<descr><![CDATA[webConfigurator default (5b59cbf93262a)]]></descr>
		<type>server</type>
		<crt>LS0tLS1CRUdJTiBDRVJUSUZJQ0FURS0tLS0tCk1JSUZqekNDQkhlZ0F3SUJBZ0lCQURBTkJna3Foa2lHOXcwQkFRc0ZBRENCdERFTE1Ba0dBMVVFQmhNQ1ZWTXgKRGpBTUJnTlZCQWdUQlZOMFlYUmxNUkV3RHdZRFZRUUhFd2hNYjJOaGJHbDBlVEU0TURZR0ExVUVDaE12Y0daVApaVzV6WlNCM1pXSkRiMjVtYVdkMWNtRjBiM0lnVTJWc1ppMVRhV2R1WldRZ1EyVnlkR2xtYVdOaGRHVXhLREFtCkJna3Foa2lHOXcwQkNRRVdHV0ZrYldsdVFIQm1VMlZ1YzJVdWJHOWpZV3hrYjIxaGFXNHhIakFjQmdOVkJBTVQKRlhCbVUyVnVjMlV0TldJMU9XTmlaamt6TWpZeVlUQWVGdzB4T0RBM01qWXhNekkyTVRkYUZ3MHlOREF4TVRZeApNekkyTVRkYU1JRzBNUXN3Q1FZRFZRUUdFd0pWVXpFT01Bd0dBMVVFQ0JNRlUzUmhkR1V4RVRBUEJnTlZCQWNUCkNFeHZZMkZzYVhSNU1UZ3dOZ1lEVlFRS0V5OXdabE5sYm5ObElIZGxZa052Ym1acFozVnlZWFJ2Y2lCVFpXeG0KTFZOcFoyNWxaQ0JEWlhKMGFXWnBZMkYwWlRFb01DWUdDU3FHU0liM0RRRUpBUllaWVdSdGFXNUFjR1pUWlc1egpaUzVzYjJOaGJHUnZiV0ZwYmpFZU1Cd0dBMVVFQXhNVmNHWlRaVzV6WlMwMVlqVTVZMkptT1RNeU5qSmhNSUlCCklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUEyaitLckhEd2hHNTVCV1N3UFRTcnZJbjkKRFhrMk5NR0VrSnZWcnE4MktscXF1ckp5bVhDMFNiNm1RTVhXMjVrVUVJSFRWNnZ3STlnSzZDTkJSSzZDQWdRWApuc2FsckoyNTg5K3oxUHE0OVlCa3R0b241WU94bGtHV2VHY1RMSUkvR2ZwTUhmSHppQVppL0x3Y0tGVVJXZmNFCm9DTStIYWcrbXgrS1ZHRCt0RGphSENaMHdMbWp4bDFKWlVlU1JqQjl1ZnJVUXlWamFNYjdFUDdSeUxGOUNsTk0KVkY2S2RRbkVoRnAyNENqMVM2T0VEM2N3VWhTYXlwanJIU3dCRm1JbllteUtnYzJlOVNua3JUd0R3blRrOE01SgpjR05XK2JzeXcrVUhQNWI2OTJjNmxhN3U0REc4dnhHOHRjQWVMMFIzRkREN0dRZ2NSSU1IeWtKSzloQmxUUUlECkFRQUJvNElCcURDQ0FhUXdDUVlEVlIwVEJBSXdBREFSQmdsZ2hrZ0JodmhDQVFFRUJBTUNCa0F3Q3dZRFZSMFAKQkFRREFnV2dNRE1HQ1dDR1NBR0crRUlCRFFRbUZpUlBjR1Z1VTFOTUlFZGxibVZ5WVhSbFpDQlRaWEoyWlhJZwpRMlZ5ZEdsbWFXTmhkR1V3SFFZRFZSME9CQllFRlBYWGhUYlZPZlJuY3dMc083VHNpaW8vMzRsM01JSGhCZ05WCkhTTUVnZGt3Z2RhQUZQWFhoVGJWT2ZSbmN3THNPN1RzaWlvLzM0bDNvWUc2cElHM01JRzBNUXN3Q1FZRFZRUUcKRXdKVlV6RU9NQXdHQTFVRUNCTUZVM1JoZEdVeEVUQVBCZ05WQkFjVENFeHZZMkZzYVhSNU1UZ3dOZ1lEVlFRSwpFeTl3WmxObGJuTmxJSGRsWWtOdmJtWnBaM1Z5WVhSdmNpQlRaV3htTFZOcFoyNWxaQ0JEWlhKMGFXWnBZMkYwClpURW9NQ1lHQ1NxR1NJYjNEUUVKQVJZWllXUnRhVzVBY0daVFpXNXpaUzVzYjJOaGJHUnZiV0ZwYmpFZU1Cd0cKQTFVRUF4TVZjR1pUWlc1elpTMDFZalU1WTJKbU9UTXlOakpoZ2dFQU1CMEdBMVVkSlFRV01CUUdDQ3NHQVFVRgpCd01CQmdnckJnRUZCUWdDQWpBZ0JnTlZIUkVFR1RBWGdoVndabE5sYm5ObExUVmlOVGxqWW1ZNU16STJNbUV3CkRRWUpLb1pJaHZjTkFRRUxCUUFEZ2dFQkFIdXFEY3FLdmt4TlhtVDJpZm9CWGtKVUhRc0xadkUwSytJSVc1ZmQKY3k2MkQ1eXEzelNES2k1Y0RmeHI3RDI0ZUorZUNWbTgwSTE3Z2RuOWpZOXR4NTVNSXFLdXdDUENMN1JTV3RFNgpsWWlRUzFxYkhBbjFCdUNaOTUyTGtMUWFYWGRSMXZ1SnF0czJwSDFESjc4SHMwcmYyNHlsbERwbjlNcTY0c0ZtCnFveDFXck13bGtncCtGbFA4VkV2ZUtGY2wxY2tYWGVEQVhRbmx6bjNhT0VYdWl5dGt3bWtiSmpmRm5tNHRTazEKY0xNRW51UHNXNDRFZk44UHJadlMvODRKVHFaTHR3V0VSVVBWTXE3a05GVUdtb3BHK3JYbDQyMExsZ1dpbXdhUQo5N2phSDNkN3RJSk1LOG42eC9vUk41RUtWbnVoOXptUWJRZUlPeTA3WXlBbTJKbz0KLS0tLS1FTkQgQ0VSVElGSUNBVEUtLS0tLQo=</crt>
		<prv>LS0tLS1CRUdJTiBQUklWQVRFIEtFWS0tLS0tCk1JSUV2Z0lCQURBTkJna3Foa2lHOXcwQkFRRUZBQVNDQktnd2dnU2tBZ0VBQW9JQkFRRGFQNHFzY1BDRWJua0YKWkxBOU5LdThpZjBOZVRZMHdZU1FtOVd1cnpZcVdxcTZzbktaY0xSSnZxWkF4ZGJibVJRUWdkTlhxL0FqMkFybwpJMEZFcm9JQ0JCZWV4cVdzbmJuejM3UFUrcmoxZ0dTMjJpZmxnN0dXUVpaNFp4TXNnajhaK2t3ZDhmT0lCbUw4CnZCd29WUkZaOXdTZ0l6NGRxRDZiSDRwVVlQNjBPTm9jSm5UQXVhUEdYVWxsUjVKR01IMjUrdFJESldOb3h2c1EKL3RISXNYMEtVMHhVWG9wMUNjU0VXbmJnS1BWTG80UVBkekJTRkpyS21Pc2RMQUVXWWlkaWJJcUJ6WjcxS2VTdApQQVBDZE9Ud3prbHdZMWI1dXpMRDVRYy9sdnIzWnpxVnJ1N2dNYnkvRWJ5MXdCNHZSSGNVTVBzWkNCeEVnd2ZLClFrcjJFR1ZOQWdNQkFBRUNnZ0VCQUtoMWgzcVhLbTl1UGllMWtudUwza3VIVHpaSksxZ0pUMk8zaFhaeWM2SzUKblRMQ2JzYVZRZlB5SHEyOGg1MjFTTkY5QkQ2VnpxUThMQjhHcDJoMk1vK1B6Uk9YVFdZeDBNaTNFVDRCMFNaZQpWbDcxZ1BvZGJzUUdHRGtUaHE5Q1VhYWhsb00rc0xWOENJZ0FRdE8yNWMvRlpXS2VFV0llN1VRYlVsRFRGWWJSCk5pMXhKVUVpYkFOV3lVaFBOcnVjQmdBTzlQNEQ4MzJScnZ3ZkgxV01jTis1dGhISzNvaWZjUkFDanRqMi9UTGMKck1MZ3BzSS9KaHVoZXhBbzFnU3MzT24vMFQ4Skd0Tmx1KzdUQjZLVXRKekhIc0thdmIwRHhaMlJrL0luZGZMeQpvOWxxNDBiWkxQbnNNWWhDMXM1cmVqcWtwQXJUamRQZUw3bWQ3SGJvRjlrQ2dZRUE4eWdsaXZsSllJeFdxUHhxCk4vT01qNUhMVUFpNjRrQlpuOU5mYnJXNnpNQkZZd3gvcnA2NDZHS2ZQcm9ERStSZGRjL2dQb2NYNEMwNlkwNHYKUnlhbkcyQS9MeXNpelp3S29UQkM2MEFlME01SFZTWDlDektHMkorQUdWTFlhaWtualpwdUlvbEZ6ZXN1Z0MveQpZeU5EZ0F3VGkzNzRQMy9WOFVQWHlXSE9PUE1DZ1lFQTVjYVhwYmkwRklTSkVWazVnTEJVZ29RRnExOXMxYjZrCmlRMFIzMmJVbTVtdnRtNzI5TUl4MXViYmNRTnBoK3ZMSWlqUE0zSWNvODZzTFo1bnRWZ0VVVkM1dVUrcjdvdTMKVDNMbHV6RW1wTktVYXdRSnpoekRVdEZQMi9EQlppd2ZISGZYOG9US0ZvSVBmV1g5Z2g0dUtldmZOMlB2VkRhcwpVaUYvWUVQMmVMOENnWUJxdW01d0o2ZDdoMTNxWXBERTZsUUNHSDVqTE5IS3lYQU5aUnY0WGpBVit6YjVtTnphCmFyVEMyN2NHTTJOeWNjUk1GK2hYeWJoREg5Y0hDNlJZMkxCMHBiUldJZHJ1NE5VUmx6dG9Rd2JEcENkUFNwTmQKUE5wUGJ3TXRHbDMvaXZ6ZmZLOW0zVllVWW14UXU3cnFwT25WNUhjWHZhMTlRY0ZJV3Z6MldjWEkzUUtCZ1FDSAp5U0ZLM09rR2l3QVpVWG9LMDZsTmE4bVI2WlYraHVmaTJlZHE5dkREZDBJQWRIamFVWHgwZS83SVBYVDZ6dHcvCk5wQ2ozVmFSY3d3SzlXWmlJejZCODB1ZCtEZ3BnMFZ6M1Bsbjh2YmNSbGxSR0pUV3llYWZwWFFsREpTdDFYc1oKTHJWZDZ4MGx5Znh2WlhzM2pyQkhNODI0aFFVazVoNVZkdGc0UWxHQUx3S0JnRHVURzV3a2RiTk5jcHZlQlByZApjRFowOHlPckFJNjJaWm84Q1ZWbHV2dVN1ZStCc2hxRDY4SXYyZCtSK1h4YjhWbHAzR1NtVWFKU2l6aWhJVy85ClVPekd6L1docUMyOUl0YXdLcHRBcmhlUTJyZ1NjRmtvOGFoYkFHd1Z6UWh0b0YwRG51WVNtMlNlVjc1WlJNZEMKMkpJM0l6d3ptS3Z1S1BMeCt0c2Yxd0JGCi0tLS0tRU5EIFBSSVZBVEUgS0VZLS0tLS0K</prv>
	</cert>
	<gateways>
		<gateway_item>
			<interface>wan</interface>
			<gateway>'.$_POST['gat_wan'].'</gateway>
			<name>GW_WAN</name>
			<weight>1</weight>
			<ipprotocol>inet</ipprotocol>
			<interval></interval>
			<descr><![CDATA[Interface wan Gateway]]></descr>
			<defaultgw></defaultgw>
		</gateway_item>';
			if($_POST['type']  == 'MPLS'){
			    $template .= '<gateway_item>
			<interface>lan</interface>
			<gateway>'.$gat_lan.'</gateway>
			<name>MPLSGW</name>
			<weight></weight>
			<ipprotocol>inet</ipprotocol>
			<descr></descr>
		</gateway_item>
		<defaultgw4>GW_WAN</defaultgw4>';
			}
	$template .= '</gateways>
	<ppps>
	</ppps>
	<installedpackages>
		<package>
			<name>Open-VM-Tools</name>
			<descr><![CDATA[VMware Tools is a suite of utilities that enhances the performance of the virtual machine\'s guest operating system and improves management of the virtual machine.]]></descr>
			<website>http://open-vm-tools.sourceforge.net/</website>
			<version>10.1.0,1</version>
			<pkginfolink>https://doc.pfsense.org/index.php/Open_VM_Tools_package</pkginfolink>
			<configurationfile>open-vm-tools.xml</configurationfile>
			<include_file>/usr/local/pkg/open-vm-tools.inc</include_file>
		</package>
		<package>
			<name>OpenVPN Client Export Utility</name>
			<internal_name>openvpn-client-export</internal_name>
			<descr><![CDATA[Allows a pre-configured OpenVPN Windows Client or Mac OS X\'s Viscosity configuration bundle to be exported directly from pfSense.]]></descr>
			<version>1.4.23</version>
			<configurationfile>openvpn-client-export.xml</configurationfile>
			<tabs>
				<tab>
					<name>Client Export</name>
					<tabgroup>OpenVPN</tabgroup>
					<url>/vpn_openvpn_export.php</url>
				</tab>
				<tab>
					<name>Shared Key Export</name>
					<tabgroup>OpenVPN</tabgroup>
					<url>/vpn_openvpn_export_shared.php</url>
				</tab>
			</tabs>
			<include_file>/usr/local/pkg/openvpn-client-export.inc</include_file>
		</package>
		<package>
			<name>FRR</name>
			<internal_name>frr</internal_name>
			<descr><![CDATA[FRR routing daemon for BGP, OSPF, and OSPF6.&lt;br /&gt;
			&lt;strong&gt;Conflicts with Quagga OSPF and OpenBGPD; these packages cannot be installed at the same time.&lt;/strong&gt;]]></descr>
			<version>0.6.4_5</version>
			<configurationfile>frr.xml</configurationfile>
			<tabs>
				<tab>
					<text><![CDATA[Global Settings]]></text>
					<url>pkg_edit.php?xml=frr.xml</url>
					<active></active>
				</tab>
				<tab>
					<text><![CDATA[Access Lists]]></text>
					<url>pkg.php?xml=frr/frr_global_acls.xml</url>
				</tab>
				<tab>
					<text><![CDATA[Prefix Lists]]></text>
					<url>pkg.php?xml=frr/frr_global_prefixes.xml</url>
				</tab>
				<tab>
					<text><![CDATA[Route Maps]]></text>
					<url>pkg.php?xml=frr/frr_global_routemaps.xml</url>
				</tab>
				<tab>
					<text><![CDATA[Raw Config]]></text>
					<url>pkg_edit.php?xml=frr/frr_global_raw.xml</url>
				</tab>
				<tab>
					<text><![CDATA[[BGP]]]></text>
					<url>pkg_edit.php?xml=frr/frr_bgp.xml</url>
				</tab>
				<tab>
					<text><![CDATA[[OSPF]]]></text>
					<url>pkg_edit.php?xml=frr/frr_ospf.xml</url>
				</tab>
				<tab>
					<text><![CDATA[[OSPF6]]]></text>
					<url>pkg_edit.php?xml=frr/frr_ospf6.xml</url>
				</tab>
				<tab>
					<text><![CDATA[Status]]></text>
					<url>/status_frr.php</url>
				</tab>
			</tabs>
			<include_file>/usr/local/pkg/frr.inc</include_file>
			<plugins>
				<item>
					<type>plugin_carp</type>
				</item>
			</plugins>
		</package>
		<service>
			<name>vmware-guestd</name>
			<rcfile>vmware-guestd.sh</rcfile>
			<custom_php_service_status_command>mwexec(&quot;/usr/local/etc/rc.d/vmware-guestd status&quot;) == 0;</custom_php_service_status_command>
			<description><![CDATA[VMware Guest Daemon]]></description>
		</service>
		<service>
			<name>vmware-kmod</name>
			<rcfile>vmware-kmod.sh</rcfile>
			<custom_php_service_status_command>mwexec(&quot;/usr/local/etc/rc.d/vmware-kmod status&quot;) == 0;</custom_php_service_status_command>
			<description><![CDATA[VMware Kernel Modules]]></description>
		</service>
		<service>
			<name>FRR zebra</name>
			<rcfile>frr.sh</rcfile>
			<executable>zebra</executable>
			<description><![CDATA[FRR core/abstraction daemon]]></description>
		</service>
		<service>
			<name>FRR staticd</name>
			<rcfile>frr.sh</rcfile>
			<executable>staticd</executable>
			<description><![CDATA[FRR static route daemon]]></description>
		</service>
		<service>
			<name>FRR bgpd</name>
			<rcfile>frr.sh</rcfile>
			<executable>bgpd</executable>
			<description><![CDATA[FRR BGP routing daemon]]></description>
		</service>
		<service>
			<name>FRR ospfd</name>
			<rcfile>frr.sh</rcfile>
			<executable>ospfd</executable>
			<description><![CDATA[FRR OSPF routing daemon]]></description>
		</service>
		<service>
			<name>FRR ospf6d</name>
			<rcfile>frr.sh</rcfile>
			<executable>ospf6d</executable>
			<description><![CDATA[FRR OSPF6 routing daemon]]></description>
		</service>
		<menu>
			<name>FRR Global/Zebra</name>
			<section>Services</section>
			<configfile>frr.xml</configfile>
			<url>/pkg_edit.php?xml=frr.xml</url>
		</menu>
		<menu>
			<name>FRR BGP</name>
			<section>Services</section>
			<configfile>frr.xml</configfile>
			<url>pkg_edit.php?xml=frr/frr_bgp.xml</url>
		</menu>
		<menu>
			<name>FRR OSPF</name>
			<section>Services</section>
			<configfile>frr.xml</configfile>
			<url>/pkg_edit.php?xml=frr/frr_ospf.xml</url>
		</menu>
		<menu>
			<name>FRR OSPF6</name>
			<section>Services</section>
			<configfile>frr.xml</configfile>
			<url>/pkg_edit.php?xml=frr/frr_ospf6.xml</url>
		</menu>
		<menu>
			<name>FRR</name>
			<section>Status</section>
			<configfile>frr.xml</configfile>
			<url>/status_frr.php</url>
		</menu>
	</installedpackages>
	<ntpd>
		<gps>
			<type>Default</type>
		</gps>
	</ntpd>
</pfsense>';



echo '<center><section>
  <div id="container">
    <input type="text" value="'.$_POST['fsn'].'.xml" placeholder="filename.txt">
    <button class="btn btn-outline-success btn-sm mb-2" onclick="downloadFile()">Génération Fichier</button> <output></output>
    <br/><br/>
    <div contenteditable style="display:none;">'.htmlspecialchars($template).'</div>
  </div>
</section>';




?>
<script>
var container = document.querySelector('#container');
var typer = container.querySelector('[contenteditable]');
var output = container.querySelector('output');

const MIME_TYPE = 'text/plain';

// Rockstars use event delegation!
document.body.addEventListener('dragstart', function(e) {
  var a = e.target;
  if (a.classList.contains('dragout')) {
    e.dataTransfer.setData('DownloadURL', a.dataset.downloadurl);
  }
}, false);

document.body.addEventListener('dragend', function(e) {
  var a = e.target;
  if (a.classList.contains('dragout')) {
    cleanUp(a);
  }
}, false);

document.addEventListener('keydown', function(e) {
  if (e.keyCode == 27) {  // Esc
    document.querySelector('details').open = false;
  } else if (e.shiftKey && e.keyCode == 191) { // shift + ?
    document.querySelector('details').open = true;
  }
}, false);

var cleanUp = function(a) {
  a.textContent = 'Downloaded';
  a.dataset.disabled = true;

  // Need a small delay for the revokeObjectURL to work properly.
  setTimeout(function() {
    window.URL.revokeObjectURL(a.href);
  }, 1500);
};

var downloadFile = function() {
  window.URL = window.webkitURL || window.URL;

  var prevLink = output.querySelector('a');
  if (prevLink) {
    window.URL.revokeObjectURL(prevLink.href);
    output.innerHTML = '';
  }

  var bb = new Blob([typer.textContent], {type: MIME_TYPE});

  var a = document.createElement('a');
  a.download = container.querySelector('input[type="text"]').value;
  a.href = window.URL.createObjectURL(bb);
  a.textContent = 'Download ready';

  a.dataset.downloadurl = [MIME_TYPE, a.download, a.href].join(':');
  a.draggable = true; // Don't really need, but good practice.
  a.classList.add('dragout');

  output.appendChild(a);

  a.onclick = function(e) {
    if ('disabled' in this.dataset) {
      return false;
    }

    cleanUp(this);
  };
};
</script>

<?php
	 exit;         
	      }
	      
	      echo $choix_port_1;
	      
	      ################### Fin Traitemement $choix NAT premiere partie #########################
