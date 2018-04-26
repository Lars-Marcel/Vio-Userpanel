----------------------------------------------------
------ Copyright (c) FirstOne Media 2014-2016 ------
----------------------------------------------------

local function newTicket(subject, message)
	local player = source
	
	local newMsg = "Spieler "..getPlayerName(player).." ["..timestamp().."]:\n"..message
	
	mysql_vio_query("INSERT INTO support (ID, player, subject, message, state) VALUES ('NULL', '"..MySQL_Save(getPlayerName(player)).."', '"..MySQL_Save(subject).."', '"..MySQL_Save(newMsg).."', 'open')")
	
	for _, admin in pairs(getElementsByType("player")) do
		if (getElementData(admin, "adminlvl") >= 1) then
			outputChatBox(getPlayerName(player).." benötigt Hilfe!", admin, 255, 155, 0)
		end
	end
	outputChatBox("Ticket erstellt.", player, 0, 255, 0)
end
addEvent("newTicket", true)
addEventHandler("newTicket", root, newTicket)

local function ticketReply(ID, message)
	local player = source
	if (MySQL_DatasetExist("support", "ID='"..MySQL_Save(ID).."'")) then
		local state = MySQL_GetString("support", "state", "ID='"..MySQL_Save(ID).."'")
		if (state == "open") then
			local msg = MySQL_GetString("support", "message", "ID='"..MySQL_Save(ID).."'")
			
			local fix = ""
			if (getElementData(player, "adminlvl") >= 1) then
				fix = "Admin"
			else
				fix = "Spieler"
			end
			fix = fix.." "..getPlayerName(player)
			
			local newMsg = fix.." ["..timestamp().."]:\n"..message.."\n\n-----------------\n\n"..msg
			
			MySQL_SetString("support", "message", MySQL_Save(newMsg), "ID='"..MySQL_Save(ID).."'")
			
			local plname = MySQL_GetString("support", "player", "ID='"..MySQL_Save(ID).."'")
			if (plname == getPlayerName(player)) then
				for _, admin in pairs(getElementsByType("player")) do
					if (getElementData(admin, "adminlvl") >= 1) then
						outputChatBox(getPlayerName(player).." hat eine Antwort auf sein Ticket ("..ID..") verfasst!", admin, 255, 155, 0)
					end
				end
			elseif (getPlayerFromName(plname)) then
				outputChatBox("Du hast eine Antwort auf dein Ticket ("..ID..") erhalten.", getPlayerFromName(plname), 255, 155, 0)
			end
			
			
			outputChatBox("Antwort abgesendet.", player, 0, 255, 0)
		else
			outputChatBox("Fehler: Das Ticket wurde bereits geschlossen.", player, 255, 100, 0)
		end
	else
		outputChatBox("Fehler: Das Ticket mit der ID "..ID.." existiert nicht.", player, 255, 100, 0)
	end
end
addEvent("ticketReply", true)
addEventHandler("ticketReply", root, ticketReply)

local function updateTicketState(ID, state)
	local player = source
	if (state == "open" or state == "closed") then
		if (MySQL_DatasetExist("support", "ID='"..MySQL_Save(ID).."'")) then
			MySQL_SetString("support", "state", MySQL_Save(state), "ID='"..MySQL_Save(ID).."'")
			local fix = "ge"
			if (state == "open") then
				fix = fix.."öffnet"
			else
				fix = fix.."schlossen"
			end
			outputChatBox("Du hast das Ticket erfolgreich "..fix..".", player, 0, 255, 0)
			
			local spieler = MySQL_GetString("support", "player", "ID='"..MySQL_Save(ID).."'")
			local spieler = getPlayerFromName(spieler)
			if (spieler) then
				outputChatBox("Dein Ticket mit der ID "..ID.." wurde von "..getPlayerName(player).." "..fix..".", spieler, 0, 255, 0)
			end
		else
			outputChatBox("Fehler: Das Ticket mit der ID "..ID.." existiert nicht.", player, 255, 100, 0)
		end
	end
end
addEvent("updateTicketState", true)
addEventHandler("updateTicketState", root, updateTicketState)

local function openTicketWindow(player, cmd)
	local tickets = {}
	
	if (cmd == "tickets") then
		sql = mysql_query(handler, "SELECT * FROM support")
	else
		sql = mysql_query(handler, "SELECT * FROM support WHERE player LIKE '"..MySQL_Save(getPlayerName(player)).."'")
	end
	
	for _, row in mysql_rows_assoc(sql) do
		local id = row["ID"]
		tickets[id] = {
			ID = id,
			player = row["player"],
			subject = row["subject"],
			message = row["message"],
			state = row["state"]
		}
	end
	
	if (cmd == "tickets" and getElementData(player, "adminlvl") >= 1) then
		triggerClientEvent(player, "showTicketWindow", player, tickets)
	elseif (cmd == "support" or cmd == "report") then
		triggerClientEvent(player, "showSupportWindow", player, tickets)
	end
	
	mysql_free_result(sql)
end
addCommandHandler("tickets", cancelEvent)
addCommandHandler("tickets", openTicketWindow)
addCommandHandler("support", openTicketWindow)
addCommandHandler("report", openTicketWindow)